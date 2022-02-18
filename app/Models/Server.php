<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['id', 'hostname', 'ipv4', 'ipv6', 'server_type', 'os_id', 'location_id', 'provider_id', 'ram', 'disk', 'ram_type', 'disk_type', 'ns1', 'ns2', 'label', 'bandwidth', 'ram_as_mb', 'disk_as_gb', 'has_yabs', 'was_promo', 'owned_since', 'ssh', 'active'];
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

}
