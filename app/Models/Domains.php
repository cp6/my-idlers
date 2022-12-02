<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Domains extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'domains';

    protected $keyType = 'string';

    protected $fillable = ['id', 'domain', 'extension', 'ns1', 'ns2', 'ns3', 'price', 'currency', 'payment_term', 'owned_since', 'provider_id', 'next_due_date'];


    public static function allDomains()
    {//All domains and relationships (no using joins)
        return Cache::remember("all_domains", now()->addMonth(1), function () {
            $query = Domains::with(['provider', 'price', 'labels']);
            if (in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $options = Settings::orderByProcess(Session::get('sort_on'));
                $query->orderBy(Pricing::select("pricings.$options[0]")->whereColumn("pricings.service_id", "domains.id"), $options[1]);
            }
            return $query->get();
        });
    }

    public static function domain(string $domain_id)
    {//Single domains and relationships (no using joins)
        return Cache::remember("domain.$domain_id", now()->addMonth(1), function () use ($domain_id) {
            return Domains::where('id', $domain_id)
                ->with(['provider', 'price', 'labels'])->first();
        });
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

    public function note(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Note::class, 'service_id', 'id');
    }

}
