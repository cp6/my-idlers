<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IPs extends Model
{
    use HasFactory;

    public $table = 'ips';

    protected $keyType = 'string';

    protected $fillable = ['id', 'active', 'service_id', 'address', 'is_ipv4'];

    public $incrementing = false;

    public static function deleteIPsAssignedTo($service_id): void
    {
        DB::table('ips')->where('service_id', $service_id)->delete();
    }

    public static function insertIP(string $service_id, string $address): IPs
    {
        return self::create(
            [
                'id' => Str::random(8),
                'service_id' => $service_id,
                'address' => $address,
                'is_ipv4' => (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? 0 : 1,
                'active' => 1
            ]
        );
    }

    public static function ipsForServer(string $server_id)
    {
        return Cache::remember("ip_addresses.$server_id", now()->addHours(1), function () use ($server_id) {
            return json_decode(DB::table('ips as i')
                ->where('i.service_id', $server_id)
                ->get(), true);
        });
    }

    public function note(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Note::class, 'service_id', 'id');
    }

}
