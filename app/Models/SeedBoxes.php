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

    public static function seedBoxesDataIndexPage()
    {
        return DB::table('seedboxes as s')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->get(['s.*', 'p.name as provider_name', 'pr.*', 'l.name as location']);
    }

    public static function seedBoxDataShowPage(string $seed_box_id)
    {
        return DB::table('seedboxes as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->where('s.id', '=', $seed_box_id)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*']);
    }

    public static function seedBoxEditDataPage(string $seed_box_id)
    {
        return DB::table('seedboxes as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->where('s.id', '=', $seed_box_id)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*']);
    }


}
