<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IPs extends Model
{
    use HasFactory;

    public $table = 'ips';

    protected $fillable = ['id', 'active', 'service_id', 'address', 'is_ipv4'];

    public $incrementing = false;

    public static function deleteIPsAssignedTo($service_id)
    {
        DB::table('ips')->where('service_id', '=', $service_id)->delete();
    }

    public static function insertIP(string $service_id, string $address)
    {
        self::create(
            [
                'id' => Str::random(8),
                'service_id' => $service_id,
                'address' => $address,
                'is_ipv4' => (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? 0 : 1,
                'active' => 1
            ]
        );
    }

}
