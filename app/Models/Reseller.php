<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Reseller extends Model
{
    use HasFactory;

    protected $table = 'reseller_hosting';

    protected $fillable = ['id', 'active', 'accounts', 'main_domain', 'has_dedicated_ip', 'ip', 'reseller_type', 'provider_id', 'location_id', 'bandwidth', 'disk', 'disk_type', 'disk_as_gb', 'domains_limit', 'subdomains_limit', 'ftp_limit', 'email_limit', 'db_limit', 'was_promo', 'owned_since'];

    public $incrementing = false;

    public static function resellerDataIndexPage()
    {
        return DB::table('reseller_hosting as s')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->get(['s.*', 'p.name as provider_name', 'pr.*', 'l.name as location']);
    }

    public static function resellerDataShowPage(string $reseller_id)
    {
        return DB::table('reseller_hosting as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->where('s.id', '=', $reseller_id)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*']);
    }

    public static function resellerDataEditPage(string $reseller_id)
    {
        return DB::table('reseller_hosting as s')
            ->join('pricings as p', 's.id', '=', 'p.service_id')
            ->where('s.id', '=', $reseller_id)
            ->get(['s.*', 'p.*']);

    }

}
