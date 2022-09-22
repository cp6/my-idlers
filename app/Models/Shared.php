<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Shared extends Model
{
    use HasFactory;

    public $table = 'shared_hosting';

    protected $keyType = 'string';

    protected $fillable = ['id', 'active', 'main_domain', 'has_dedicated_ip', 'ip', 'shared_type', 'provider_id', 'location_id', 'bandwidth', 'disk', 'disk_type', 'disk_as_gb', 'domains_limit', 'subdomains_limit', 'ftp_limit', 'email_limit', 'db_limit', 'was_promo', 'owned_since'];

    public $incrementing = false;

    public static function allSharedHosting()
    {//All shared hosting and relationships (no using joins)
        return Cache::remember("all_shared", now()->addMonth(1), function () {
            return Shared::with(['location', 'provider', 'price', 'ips', 'labels', 'labels.label'])->get();
        });
    }

    public static function sharedHosting(string $shared_id)
    {//Single shared hosting and relationships (no using joins)
        return Cache::remember("shared_hosting.$shared_id", now()->addMonth(1), function () use ($shared_id) {
            return Shared::where('id', $shared_id)
                ->with(['location', 'provider', 'price', 'ips', 'labels', 'labels.label'])->first();
        });
    }

    public function ips()
    {
        return $this->hasMany(IPs::class, 'service_id', 'id');
    }

    public function location()
    {
        return $this->hasOne(Locations::class, 'id', 'location_id');
    }

    public function provider()
    {
        return $this->hasOne(Providers::class, 'id', 'provider_id');
    }

    public function price()
    {
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

    public function labels()
    {
        return $this->hasMany(LabelsAssigned::class, 'service_id', 'id');
    }

}
