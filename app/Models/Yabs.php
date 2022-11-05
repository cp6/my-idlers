<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Yabs extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'yabs';

    protected $fillable = ['id', 'server_id', 'has_ipv6', 'aes', 'vm', 'output_date', 'cpu_cores', 'cpu_freq', 'cpu_model', 'ram', 'ram_type', 'ram_mb', 'disk', 'disk_type', 'disk_gb', 'gb5_single', 'gb5_multi', 'gb5_id', '4k', '4k_type', '4k_as_mbps', '64k', '64k_type', '64k_as_mbps', '512k', '512k_type', '512k_as_mbps', '1m', '1m_type', '1m_as_mbps', 'location', 'send', 'send_type', 'send_as_mbps', 'receive', 'receive_type', 'receive_as_mbps', 'uptime', 'distro', 'kernel', 'swap', 'swap_type', 'swap_mb'];

    public static function yabs(string $yabs_id)
    {
        return Cache::remember("yabs.$yabs_id", now()->addMonth(1), function () use ($yabs_id) {
            return self::where('id', $yabs_id)->with(['server', 'disk_speed', 'network_speed', 'server.location', 'server.provider'])
                ->first();
        });
    }

    public static function allYabs()
    {
        return Cache::remember("all_yabs", now()->addMonth(1), function () {
            return self::with(['server', 'disk_speed', 'network_speed', 'server.location', 'server.provider'])
                ->get();
        });
    }

    public function server()
    {
        return $this->hasOne(Server::class, 'id', 'server_id');
    }

    public function disk_speed()
    {
        return $this->hasOne(DiskSpeed::class, 'id', 'id');
    }

    public function network_speed()
    {
        return $this->hasMany(NetworkSpeed::class, 'id', 'id');
    }

    public static function buildYabsArray($data): array
    {
        $speed_tests = [];
        foreach ($data->network_speed as $ns) {
            $speed_tests[] = array(
                'location' => $ns->location,
                'send' => $ns->send . ' ' . $ns->send_type,
                'receive' => $ns->receive . ' ' . $ns->receive_type,
            );
        }
        return array(
            'date_time' => $data->output_date,
            'location' => $data->server->location->name,
            'provider' => $data->server->provider->name,
            'uptime' => $data->uptime,
            'distro' => $data->distro,
            'kernel' => $data->kernel,
            'cpu' => array(
                'cores' => $data->cpu_cores,
                'speed_mhz' => $data->cpu_freq,
                'model' => $data->cpu_model,
                'aes' => $data->aes === 1,
                'vm' => $data->vm === 1,
                'GB5_single' => $data->gb5_single,
                'GB5_multi' => $data->gb5_multi,
            ),
            'ram' => array(
                'amount' => $data->ram . ' ' . $data->ram_type,
                'mb' => $data->ram_mb,
                'swap' => array(
                    'amount' => $data->swap ?? null . ' ' . $data->swap_type ?? null,
                    'mb' => $data->swap_mb ?? null,
                ),
            ),
            'disk' => array(
                'amount' => $data->disk . ' ' . $data->disk_type,
                'gb' => $data->disk_gb,
                'speed_tests' => array(
                    '4k' => $data->disk_speed->d_4k . ' ' . $data->disk_speed->d_4k_type,
                    '64k' => $data->disk_speed->d_64k . ' ' . $data->disk_speed->d_64k_type,
                    '512k' => $data->disk_speed->d_512k . ' ' . $data->disk_speed->d_512k_type,
                    '1m' => $data->disk_speed->d_1m . ' ' . $data->disk_speed->d_1m_type,
                ),
            ),
            'network' => array(
                'has_ipv6' => $data->has_ipv6 === 1,
                'speed_tests' => $speed_tests
            ),
        );
    }

    public static function speedAsMbps(string $string): float
    {
        $data = explode(" ", $string);
        if ($data[0] === 'busy') {
            return 0;
        }
        if ($data[1] === "Gbits/sec") {
            return $data[0] * 1000;
        } else if ($data[1] === "Mbits/sec") {
            return $data[0];
        } else {//Kbps
            return $data[0] / 1000;
        }
    }

    public static function speedType(string $string): string
    {
        $data = explode(" ", $string);
        if ($data[0] === 'busy') {
            return "MBps";
        }
        if ($data[1] === "Gbits/sec") {
            return "GBps";
        } else if ($data[1] === "Mbits/sec") {
            return "MBps";
        } else {//Kbps
            return "KBps";
        }
    }

    public static function speedAsFloat(string $string): float
    {
        $data = explode(" ", $string);
        if ($data[0] === 'busy') {
            return 0;
        }
        return (float)$data[0];
    }

    public static function formatRunTime(string $date): string
    {
        return DateTime::createFromFormat('Ymd-His', $date)->format('Y-m-d H:i:s');
    }

    public static function gb5IdFromURL(string $url): int
    {
        return str_replace("https://browser.geekbench.com/v5/cpu/", "", $url);
    }

    public static function KBstoMBs(int $kbs): float
    {
        return $kbs / 1000;
    }

    public static function insertFromJson($data, string $server_id)
    {
        $data = (object)$data;
        try {
            $date_ran = self::formatRunTime($data->time);
            $version = $data['version'];
            $has_ipv4 = $data['net']['ipv4'];
            $has_ipv6 = $data['net']['ipv6'];
            //OS
            $arch = $data['os']['arch'];
            $distro = $data['os']['distro'];
            $kernel = $data['os']['kernel'];
            $uptime = $data['os']['uptime'];
            //CPU
            $model = $data['cpu']['model'];
            $cores = $data['cpu']['cores'];
            $freq = $data['cpu']['freq'];
            $aes = $data['cpu']['aes'];
            $virt = $data['cpu']['virt'];
            //RAM Disk
            $ram = $data['mem']['ram'];
            $swap = $data['mem']['swap'];
            $disk = $data['mem']['disk'];
            if (isset($data['geekbench'][0]) && $data['geekbench'][0]['version'] === 5) {
                $gb5_single = $data['geekbench'][0]['single'];
                $gb5_multi = $data['geekbench'][0]['multi'];
                $gb5_id = self::gb5IdFromURL($data['geekbench'][0]['url']);
            } elseif (isset($data['geekbench'][1]) && $data['geekbench'][1]['version'] === 5) {
                $gb5_single = $data['geekbench'][1]['single'];
                $gb5_multi = $data['geekbench'][1]['multi'];
                $gb5_id = self::gb5IdFromURL($data['geekbench'][1]['url']);
            } else {
                $gb5_single = $gb5_multi = $gb5_id = null;
            }

            $yabs_id = Str::random(8);

            if ($ram > 999999) {
                $ram_f = ($ram / 1024 / 1024);
                $ram_type = 'GB';
            } else {
                $ram_f = ($ram / 1024);
                $ram_type = 'MB';
            }

            if ($disk > 100000000) {
                $disk_f = ($disk / 1024 / 1024 / 1024);
                $disk_type = 'TB';
            } else {
                $disk_f = ($disk / 1024 / 1024);
                $disk_type = 'GB';
            }

            self::create([
                'id' => $yabs_id,
                'server_id' => $server_id,
                'has_ipv6' => $has_ipv6,
                'aes' => $aes,
                'vm' => $virt,
                'distro' => $distro,
                'kernel' => $kernel,
                'uptime' => $uptime,
                'cpu_model' => $model,
                'cpu_cores' => $cores,
                'cpu_freq' => (float)$freq,
                'ram' => $ram_f,
                'ram_type' => $ram_type,
                'ram_mb' => ($ram / 1024),
                'swap' => $swap / 1024,
                'swap_mb' => ($swap / 1024),
                'swap_type' => 'MB',
                'disk' => $disk_f,
                'disk_gb' => ($disk / 1024 / 1024),
                'disk_type' => $disk_type,
                'output_date' => $date_ran,
                'gb5_single' => $gb5_single,
                'gb5_multi' => $gb5_multi,
                'gb5_id' => $gb5_id
            ]);

            //fio
            foreach ($data['fio'] as $ds) {
                if ($ds['bs'] === '4k') {
                    $d4k = ($ds['speed_rw'] > 999999) ? ($ds['speed_rw'] / 1000 / 1000) : $ds['speed_rw'] / 1000;
                    $d4k_type = ($ds['speed_rw'] > 999999) ? 'GB/s' : 'MB/s';
                    $d4k_mbps = self::KBstoMBs($ds['speed_rw']);
                }
                if ($ds['bs'] === '64k') {
                    $d64k = ($ds['speed_rw'] > 999999) ? ($ds['speed_rw'] / 1000 / 1000) : $ds['speed_rw'] / 1000;
                    $d64k_type = ($ds['speed_rw'] > 999999) ? 'GB/s' : 'MB/s';
                    $d64k_mbps = self::KBstoMBs($ds['speed_rw']);
                }
                if ($ds['bs'] === '512k') {
                    $d512k = ($ds['speed_rw'] > 999999) ? ($ds['speed_rw'] / 1000 / 1000) : $ds['speed_rw'] / 1000;
                    $d512k_type = ($ds['speed_rw'] > 999999) ? 'GB/s' : 'MB/s';
                    $d512k_mbps = self::KBstoMBs($ds['speed_rw']);
                }
                if ($ds['bs'] === '1m') {
                    $d1m = ($ds['speed_rw'] > 999999) ? ($ds['speed_rw'] / 1000 / 1000) : $ds['speed_rw'] / 1000;
                    $d1m_type = ($ds['speed_rw'] > 999999) ? 'GB/s' : 'MB/s';
                    $d1m_mbps = self::KBstoMBs($ds['speed_rw']);
                }
            }

            DiskSpeed::create([
                'id' => $yabs_id,
                'server_id' => $server_id,
                'd_4k' => $d4k,
                'd_4k_type' => $d4k_type,
                'd_4k_as_mbps' => $d4k_mbps,
                'd_64k' => $d64k,
                'd_64k_type' => $d64k_type,
                'd_64k_as_mbps' => $d64k_mbps,
                'd_512k' => $d512k,
                'd_512k_type' => $d512k_type,
                'd_512k_as_mbps' => $d512k_mbps,
                'd_1m' => $d1m,
                'd_1m_type' => $d1m_type,
                'd_1m_as_mbps' => $d1m_mbps
            ]);

            //iperf
            foreach ($data['iperf'] as $st) {
                ($has_ipv4) ? $match = 'IPv4' : $match = 'IPv6';
                if ($st['mode'] === $match) {
                    if ($st['send'] !== "busy " || $st['recv'] !== "busy ") {
                        NetworkSpeed::create([
                            'id' => $yabs_id,
                            'server_id' => $server_id,
                            'location' => $st['loc'],
                            'send' => self::speedAsFloat($st['send']),
                            'send_type' => self::speedType($st['send']),
                            'send_as_mbps' => self::speedAsMbps($st['send']),
                            'receive' => self::speedAsFloat($st['recv']),
                            'receive_type' => self::speedType($st['recv']),
                            'receive_as_mbps' => self::speedAsMbps($st['recv'])
                        ]);
                    }
                }
            }

            //Update server
            $update_server = DB::table('servers')
                ->where('id', $server_id)
                ->update([
                    'ram' => $ram_f,
                    'ram_type' => $ram_type,
                    'ram_as_mb' => ($ram / 1024),
                    'disk' => $disk_f,
                    'disk_as_gb' => ($disk / 1024 / 1024),
                    'disk_type' => $disk_type,
                    'cpu' => $cores,
                    'has_yabs' => 1
                ]);

            Cache::forget("yabs.$yabs_id");
            Cache::forget("all_yabs");
            Cache::forget("server.$server_id");
            Cache::forget("all_servers");

        } catch (Exception $e) {//Not valid JSON
            return false;
        }
        return true;
    }

}
