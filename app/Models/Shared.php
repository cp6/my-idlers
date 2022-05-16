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

    protected $fillable = ['id', 'active', 'main_domain', 'has_dedicated_ip', 'ip', 'shared_type', 'provider_id', 'location_id', 'bandwidth', 'disk', 'disk_type', 'disk_as_gb', 'domains_limit', 'subdomains_limit', 'ftp_limit', 'email_limit', 'db_limit', 'was_promo', 'owned_since'];

    public $incrementing = false;

    public static function sharedDataIndexPage()
    {
        return DB::table('shared_hosting as s')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->get(['s.*', 'p.name as provider_name', 'pr.*', 'l.name as location']);
    }

    public static function sharedDataShowPage(string $shared_id)
    {
        return DB::table('shared_hosting as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->where('s.id', '=', $shared_id)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*']);
    }

    public static function sharedEditDataPage(string $shared_id)
    {
        return DB::table('shared_hosting as s')
            ->join('pricings as p', 's.id', '=', 'p.service_id')
            ->where('s.id', '=', $shared_id)
            ->get(['s.*', 'p.*']);
    }
}
