<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Server extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['id', 'hostname', 'ipv4', 'ipv6', 'server_type', 'os_id', 'location_id', 'provider_id', 'ram', 'disk', 'ram_type', 'disk_type', 'ns1', 'ns2', 'label', 'bandwidth', 'ram_as_mb', 'disk_as_gb', 'has_yabs', 'was_promo', 'owned_since', 'ssh', 'active', 'show_public'];
    /**
     * @var mixed
     */
    private $id;

    public static function serviceServerType($type)
    {
        if ($type === 1) {
            return "KVM";
        } elseif ($type === 2) {
            return "OVZ";
        } elseif ($type === 3) {
            return "DEDI";
        } elseif ($type === 4) {
            return "LXC";
        } elseif ($type === 6) {
            return "VMware";
        } else {
            return "SEMI-DEDI";
        }
    }

    public static function osIntToIcon(int $os, string $os_name)
    {
        if ($os === 1) {//None
            return "<i class='fas fa-expand' title='{$os_name}'></i>";
        } else if ($os <= 3) {//Centos
            return "<i class='fab fa-centos os-icon' title='{$os_name}'></i>";
        } elseif ($os > 3 && $os <= 6) {//Debain
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 6 && $os < 10) {//Fedora
            return "<i class='fab fa-fedora os-icon' title='{$os_name}'></i>";
        } elseif ($os > 10 && $os < 13) {//FreeBSD
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 13 && $os < 16) {//OpenBSD
            return "<i class='fab fa-linux os-icon' title='{$os_name}'></i>";
        } elseif ($os > 15 && $os < 21) {//Ubuntu
            return "<i class='fab fa-ubuntu os-icon' title='{$os_name}'></i>";
        } elseif ($os > 20 && $os < 26) {//Windows
            return "<i class='fab fa-windows os-icon' title='{$os_name}'></i>";
        } else {//OTHER ISO CUSTOM etc
            return "<i class='fas fa-compact-disc os-icon' title='{$os_name}'></i>";
        }
    }

    public static function osIdAsString($os)
    {
        if ($os === "0") {
            return "None";
        } elseif ($os === "1") {
            return "CentOS 7";
        } elseif ($os === "2") {
            return "CentOS 8";
        } elseif ($os === "3") {
            return "CentOS";
        } elseif ($os === "4") {
            return "Debian 9";
        } elseif ($os === "5") {
            return "Debian 10";
        } elseif ($os === "6") {
            return "Debian";
        } elseif ($os === "7") {
            return "Fedora 32";
        } elseif ($os === "8") {
            return "Fedora 33";
        } elseif ($os === "9") {
            return "Fedora";
        } elseif ($os === "10") {
            return "FreeBSD 11.4";
        } elseif ($os === "11") {
            return "FreeBSD 12.1";
        } elseif ($os === "12") {
            return "FreeBSD";
        } elseif ($os === "13") {
            return "OpenBSD 6.7";
        } elseif ($os === "14") {
            return "OpenBSD 6.8";
        } elseif ($os === "15") {
            return "OpenBSD";
        } elseif ($os == "16") {
            return "Ubuntu 16.04";
        } elseif ($os === "17") {
            return "Ubuntu 18.04";
        } elseif ($os === "18") {
            return "Ubuntu 20.04";
        } elseif ($os === "19") {
            return "Ubuntu 20.10";
        } elseif ($os === "20") {
            return "Ubuntu";
        } elseif ($os === "21") {
            return "Windows Server 2008";
        } elseif ($os === "22") {
            return "Windows Server 2012";
        } elseif ($os === "23") {
            return "Windows Server 2016";
        } elseif ($os === "24") {
            return "Windows Server 2019";
        } elseif ($os === "25") {
            return "Windows 10";
        } elseif ($os === "26") {
            return "Custom";
        } elseif ($os === "27") {
            return "Other";
        } else {
            return "Unknown";
        }
    }

    public static function tableRowCompare(string $val1, string $val2, string $value_type = '', bool $is_int = true)
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
        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache
        Cache::forget('servers_summary');//servers summary cache
        Cache::forget('public_server_data');//public servers
        Cache::forget('all_pricing');//All pricing
        Cache::forget('services_count_all');
        Cache::forget('pricing_breakdown');
    }

    public static function serverSpecificCacheForget(string $server_id): void
    {
        Cache::forget("server_show_data.$server_id");//data for show
        Cache::forget("ip_addresses.$server_id");//ips for server
        Cache::forget("labels_for_service.$server_id");//labels for server
        Cache::forget("service_pricing.$server_id");//Pricing
    }

    public static function activeServersDataIndexPage()
    {
        return Cache::remember('all_active_servers', now()->addMonth(1), function () {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->join('os as o', 's.os_id', '=', 'o.id')
                ->where('s.active', '=', 1)
                ->get(['s.*', 'pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'pr.next_due_date', 'p.name as provider_name', 'l.name as location', 'o.name as os_name']);
        });
    }

    public static function nonActiveServersDataIndexPage()
    {
        return Cache::remember('non_active_servers', now()->addMonth(1), function () {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->join('os as o', 's.os_id', '=', 'o.id')
                ->where('s.active', '=', 0)
                ->get(['s.*', 'pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'p.name as provider_name', 'l.name as location', 'o.name as os_name']);
        });
    }

    public static function serverDataShowPage(string $server_id)
    {
        return Cache::remember("server_show_data.$server_id", now()->addDay(1), function () use ($server_id) {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->join('os as o', 's.os_id', '=', 'o.id')
                ->Leftjoin('yabs as y', 's.id', '=', 'y.server_id')
                ->Leftjoin('disk_speed as ds', 'y.id', '=', 'ds.id')
                ->where('s.id', '=', $server_id)
                ->get(['s.*', 'p.name as provider', 'l.name as location', 'o.name as os_name', 'pr.*', 'y.*', 'ds.*']);
        });
    }

    public static function publicServerData()
    {
        return Cache::remember('public_server_data', now()->addMonth(1), function () {
            return DB::table('servers as s')
                ->Join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->Join('providers as p', 's.provider_id', '=', 'p.id')
                ->Join('locations as l', 's.location_id', '=', 'l.id')
                ->Join('os as o', 's.os_id', '=', 'o.id')
                ->LeftJoin('ips as i', 's.id', '=', 'i.service_id')
                ->LeftJoin('yabs as y', 's.id', '=', 'y.server_id')
                ->LeftJoin('disk_speed as ds', 'y.id', '=', 'ds.id')
                ->where('s.show_public', '=', 1)
                ->get(['pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'pr.next_due_date', 'pr.service_id', 'p.name as provider_name', 'l.name as location', 'o.name as os_name', 'y.*', 'y.id as yabs_id', 'ds.*', 's.*', 'i.address as ip', 'i.is_ipv4']);
        });
    }

    public static function serverCompareData(string $server_id)
    {
        return Cache::remember("server_compare.$server_id", now()->addMonth(1), function () use ($server_id) {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->Join('yabs as y', 's.id', '=', 'y.server_id')
                ->Join('disk_speed as ds', 'y.id', '=', 'ds.id')
                ->where('s.id', '=', $server_id)
                ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*', 'y.*', 'y.id as yabs_id', 'ds.*']);
        });
    }

}
