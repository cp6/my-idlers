<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Reseller extends Model
{
    use HasFactory;

    protected $table = 'reseller_hosting';

    protected $keyType = 'string';

    protected $fillable = ['id', 'active', 'accounts', 'main_domain', 'has_dedicated_ip', 'ip', 'reseller_type', 'provider_id', 'location_id', 'bandwidth', 'disk', 'disk_type', 'disk_as_gb', 'domains_limit', 'subdomains_limit', 'ftp_limit', 'email_limit', 'db_limit', 'was_promo', 'owned_since'];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $array = Settings::orderByProcess(Session::get('sort_on'));
            if (!in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $builder->orderBy($array[0], $array[1]);
            }
        });
    }

    public static function allResellerHosting()
    {//All reseller hosting and relationships (no using joins)
        return Cache::remember("all_reseller", now()->addMonth(1), function () {
            return Reseller::with(['location', 'provider', 'price', 'ips', 'labels'])->get();
        });
    }

    public static function resellerHosting(string $shared_id)
    {//Single reseller hosting and relationships (no using joins)
        return Cache::remember("reseller_hosting.$shared_id", now()->addMonth(1), function () use ($shared_id) {
            return Reseller::where('id', $shared_id)
                ->with(['location', 'provider', 'price', 'ips', 'labels'])->first();
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
        if (in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
            return $this->hasOne(Pricing::class, 'service_id', 'id')->orderBy(Settings::orderByProcess(Session::get('sort_on'))[0], Settings::orderByProcess(Session::get('sort_on'))[1]);
        }
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

    public function labels()
    {
        return $this->hasMany(LabelsAssigned::class, 'service_id', 'id');
    }

}
