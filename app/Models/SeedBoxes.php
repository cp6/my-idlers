<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SeedBoxes extends Model
{
    use HasFactory;

    protected $table = 'seedboxes';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'active', 'title', 'hostname', 'seed_box_type', 'provider_id', 'location_id', 'bandwidth', 'port_speed', 'disk', 'disk_type', 'disk_as_gb', 'was_promo', 'owned_since'];

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

    public static function allSeedboxes()
    {//All seedboxes and relationships (no using joins)
        return Cache::remember("all_seedboxes", now()->addMonth(1), function () {
            return SeedBoxes::with(['location', 'provider', 'price'])->get();
        });
    }

    public static function seedbox(string $seedbox_id)
    {//Single seedbox and relationships (no using joins)
        return Cache::remember("seedbox.$seedbox_id", now()->addMonth(1), function () use ($seedbox_id) {
            return SeedBoxes::where('id', $seedbox_id)
                ->with(['location', 'provider', 'price'])->first();
        });
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
