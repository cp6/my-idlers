<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class Server extends Model
{
    use HasFactory;

    protected $table = 'servers';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'hostname', 'ipv4', 'ipv6', 'server_type', 'os_id', 'location_id', 'provider_id',
        'ram', 'disk', 'ram_type', 'disk_type', 'ns1', 'ns2', 'label', 'bandwidth', 'ram_as_mb', 'disk_as_gb',
        'has_yabs', 'was_promo', 'owned_since', 'ssh', 'active', 'show_public', 'cpu'];
    /**
     * @var mixed
     */
    private $id;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $array = Settings::orderByProcess(Session::get('sort_on') ?? 2);//created_at desc if not set
            if (!in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $builder->orderBy($array[0], $array[1]);
            }
        });
    }

    public static function allServers()
    {//All servers and relationships (no using joins)
        return Cache::remember("all_servers", now()->addMonth(1), function () {
            $query = Server::with(['location', 'provider', 'os', 'price', 'ips', 'yabs', 'yabs.disk_speed', 'yabs.network_speed', 'labels']);
            if (in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $options = Settings::orderByProcess(Session::get('sort_on'));
                $query->orderBy(Pricing::select("pricings.$options[0]")->whereColumn("pricings.service_id", "servers.id"), $options[1]);
            }
            return $query->get();
        });
    }

    public static function server(string $server_id): Server
    {//Single server and relationships (no using joins)
        return Cache::remember("server.$server_id", now()->addMonth(1), function () use ($server_id) {
            return Server::where('id', $server_id)
                ->with(['location', 'provider', 'os', 'price', 'ips', 'yabs', 'yabs.disk_speed', 'yabs.network_speed', 'labels'])->first();
        });
    }

    public static function allActiveServers()
    {//All ACTIVE servers and relationships replaces activeServersDataIndexPage()
        return Cache::remember("all_active_servers", now()->addMonth(1), function () {
            $query = Server::where('active', 1)
                ->with(['location', 'provider', 'os', 'ips', 'yabs', 'yabs.disk_speed', 'yabs.network_speed', 'labels', 'price']);
            if (in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $options = Settings::orderByProcess(Session::get('sort_on'));
                $query->orderBy(Pricing::select("pricings.$options[0]")->whereColumn("pricings.service_id", "servers.id"), $options[1]);
            }
            return $query->get();
        });
    }

    public static function allNonActiveServers()
    {//All NON ACTIVE servers and relationships replaces nonActiveServersDataIndexPage()
        return Cache::remember("non_active_servers", now()->addMonth(1), function () {
            return Server::where('active', 0)
                ->with(['location', 'provider', 'os', 'price', 'ips', 'yabs', 'yabs.disk_speed', 'yabs.network_speed', 'labels'])
                ->get();
        });
    }

    public static function allPublicServers()
    {//server data that will be publicly viewable (values in settings)
        return Cache::remember("public_server_data", now()->addMonth(1), function () {
            return Server::where('show_public', 1)
                ->with(['location', 'provider', 'os', 'price', 'ips', 'yabs', 'yabs.disk_speed', 'yabs.network_speed', 'labels'])
                ->get();
        });
    }

    public static function serviceServerType(int $type, bool $short = true): string
    {
        if ($type === 1) {
            return "KVM";
        } elseif ($type === 2) {
            return "OVZ";
        } elseif ($type === 3) {
            if (!$short) {
                return "Dedicated";
            }
            return "DEDI";
        } elseif ($type === 4) {
            return "LXC";
        } elseif ($type === 6) {
            return "VMware";
        } elseif ($type === 7) {
            return "NAT";
        } elseif ($type === 8) {
            if (!$short) {
                return "Colocated";
            }
            return "COLO";
        } else {
            if (!$short) {
                return "Semi-dedicated";
            }
            return "SEMI-DEDI";
        }
    }

    public static function osIntToIcon(int $os, string $os_name): string
    {
        if ($os === 1) {//None
            return "<i class='fas fa-expand' title='{$os_name}'></i>";
        } else if ($os <= 3) {//Centos
            return "<i class='fab fa-centos os-icon' title='{$os_name}'></i>";
        } elseif ($os > 7 && $os <= 11) {//Debain
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 12 && $os < 15) {//Fedora
            return "<i class='fab fa-fedora os-icon' title='{$os_name}'></i>";
        } elseif ($os > 14 && $os < 18) {//FreeBSD
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 17 && $os < 21) {//OpenBSD
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 25 && $os < 32) {//Ubuntu
            return "<i class='fab fa-ubuntu os-icon' title='{$os_name}'></i>";
        } elseif ($os > 32 && $os < 38) {//Windows
            return "<i class='fab fa-windows os-icon' title='{$os_name}'></i>";
        } else {//OTHER ISO CUSTOM etc
            return "<i class='fas fa-compact-disc os-icon' title='{$os_name}'></i>";
        }
    }

    public static function tableRowCompare(string $val1, string $val2, string $value_type = '', bool $is_int = true): string
    {
        //<td class="td-nowrap plus-td">+303<span class="data-type">MBps</span></td>
        $str = '<td class="td-nowrap ';
        $value_append = '<span class="data-type">' . $value_type . '</span>';
        if ($is_int) {
            $val1 = (int)$val1;
            $val2 = (int)$val2;
        }
        if ($val1 > $val2) {//val1 is greater than val2
            $result = '+' . ($val1 - $val2);
            if (!empty($value_type)) {
                $result = '+' . ($val1 - $val2) . $value_append;

            }
            $str .= 'plus-td">' . $result . '</td>';
        } elseif ($val1 < $val2) {//val1 is less than val2
            $result = '-' . ($val2 - $val1);
            if (!empty($value_type)) {
                $result = '-' . ($val2 - $val1) . $value_append;
            }
            $str .= 'neg-td">' . $result . '</td>';
        } else {//Equal
            $result = 0;
            if (!empty($value_type)) {
                $result = '0' . $value_append;
            }
            $str .= 'equal-td">' . $result . '</td>';
        }
        return $str;
    }

    public static function serverRelatedCacheForget(): void
    {
        Cache::forget('all_servers');//All servers
        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_active_servers');//all active servers cache
        Cache::forget('non_active_servers');//all non active servers cache
        Cache::forget('servers_summary');//servers summary cache
        Cache::forget('public_server_data');//public servers
        Cache::forget('all_pricing');//All pricing
        Cache::forget('services_count_all');
        Cache::forget('pricing_breakdown');
        Cache::forget('all_active_pricing');
    }

    public static function serverSpecificCacheForget(string $server_id): void
    {
        Cache::forget("server.$server_id");//Will replace one below
        Cache::forget("service_pricing.$server_id");//Pricing
    }

    public static function serverYabsAmount(string $server_id): int
    {//Returns amount of YABS a server has
        return Yabs::where('server_id', $server_id)->count();
    }

    public function yabs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Yabs::class, 'server_id', 'id');
    }

    public function ips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(IPs::class, 'service_id', 'id');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Locations::class, 'id', 'location_id');
    }

    public function provider(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Providers::class, 'id', 'provider_id');
    }

    public function os(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OS::class, 'id', 'os_id');
    }

    public function price(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

    public function labels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LabelsAssigned::class, 'service_id', 'id');
    }

    public function note(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Note::class, 'service_id', 'id');
    }

}
