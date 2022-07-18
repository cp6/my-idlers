<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Yabs extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'yabs';

    protected $fillable = ['id', 'server_id', 'has_ipv6', 'aes', 'vm', 'output_date', 'cpu_cores', 'cpu_freq', 'cpu_model', 'ram', 'ram_type', 'ram_mb', 'disk', 'disk_type', 'disk_gb', 'gb5_single', 'gb5_multi', 'gb5_id', '4k', '4k_type', '4k_as_mbps', '64k', '64k_type', '64k_as_mbps', '512k', '512k_type', '512k_as_mbps', '1m', '1m_type', '1m_as_mbps', 'location', 'send', 'send_type', 'send_as_mbps', 'receive', 'receive_type', 'receive_as_mbps'];

    public static function networkSpeedsForServer(string $server_id)
    {
        return Cache::remember("network_speeds.$server_id", now()->addMonth(1), function () use ($server_id) {
            return json_decode(DB::table('network_speed')
                ->where('network_speed.server_id', '=', $server_id)
                ->get(), true);
        });
    }

    public static function serverCompareNetwork(string $yabs_id)
    {
        return Cache::remember("compare_network_speeds.$yabs_id", now()->addMonth(1), function () use ($yabs_id) {
            return DB::table('network_speed')
                ->where('id', '=', $yabs_id)
                ->get();
        });
    }

    public static function yabs(string $yabs_id)
    {
        return Cache::remember("yabs.$yabs_id", now()->addMonth(1), function () use ($yabs_id) {
            return self::where('id', $yabs_id)->with(['server', 'disk_speed', 'network_speed'])
                ->get();
        });
    }

    public static function allYabs()
    {
        return Cache::remember("all_yabs", now()->addMonth(1), function () {
            return self::with(['server', 'disk_speed', 'network_speed'])
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

}
