<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DNS extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'service_id', 'hostname', 'dns_type', 'address', 'server_id', 'domain_id'];

    public static $dns_types = ['A', 'AAAA', 'DNAME', 'MX', 'NS', 'SOA', 'TXT', 'URI'];

    public static function dnsCount()
    {
        return Cache::remember('dns_count', now()->addMonth(1), function () {
            return DB::table('d_n_s')->count();
        });
    }
}
