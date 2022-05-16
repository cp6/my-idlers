<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Domains extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['id', 'domain', 'extension', 'ns1', 'ns2', 'ns3', 'price', 'currency', 'payment_term', 'owned_since', 'provider_id', 'next_due_date'];

    public static function domainsDataIndexPage()
    {
        return DB::table('domains as d')
            ->join('providers as p', 'd.provider_id', '=', 'p.id')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->get(['d.*', 'p.name as provider_name', 'pr.*']);
    }

    public static function domainsDataShowPage(string $domain_id)
    {
        return DB::table('domains as d')
            ->join('providers as p', 'd.provider_id', '=', 'p.id')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->where('d.id', '=', $domain_id)
            ->get(['d.*', 'p.name as provider_name', 'pr.*']);
    }

    public static function domainsDataEditPage(string $domain_id)
    {
        return DB::table('domains as d')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->where('d.id', '=', $domain_id)
            ->get(['d.*', 'pr.*']);
    }
}
