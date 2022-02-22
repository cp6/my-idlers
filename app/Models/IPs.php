<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

}
