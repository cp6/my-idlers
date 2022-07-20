<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SeedBoxes extends Model
{
    use HasFactory;

    protected $table = 'seedboxes';

    public $incrementing = false;

    protected $fillable = ['id', 'active', 'title', 'hostname', 'seed_box_type', 'provider_id', 'location_id', 'bandwidth', 'port_speed', 'disk', 'disk_type', 'disk_as_gb', 'was_promo', 'owned_since'];

    public static function allSeedboxes()
    {//All seedboxes and relationships (no using joins)
        return Cache::remember("all_seedboxes", now()->addMonth(1), function () {
            return SeedBoxes::with(['location', 'provider', 'price', 'labels.label'])->get();
        });
    }

    public static function seedbox(string $seedbox_id)
    {//Single seedbox and relationships (no using joins)
        return Cache::remember("seedbox.$seedbox_id", now()->addMonth(1), function () use ($seedbox_id) {
            return SeedBoxes::where('id', $seedbox_id)
                ->with(['location', 'provider', 'price', 'labels.label'])->get();
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
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

    public function labels()
    {
        return $this->hasMany(LabelsAssigned::class, 'service_id', 'id');
    }

}
