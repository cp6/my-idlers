<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Home extends Model
{
    use HasFactory;

    public static function homePageCacheForget()
    {
        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_pricing');//All the pricing
    }

    public static function servicesCount()
    {
        return Cache::remember('services_count', now()->addHour(6), function () {
            return DB::table('pricings')
                ->select('service_type', DB::raw('COUNT(*) as amount'))
                ->groupBy('service_type')
                ->where('active', '=', 1)
                ->get();
        });
    }

    public static function dueSoonData()
    {
        return Cache::remember('due_soon', now()->addHour(6), function () {
            return DB::table('pricings as p')
                ->leftJoin('servers as s', 'p.service_id', '=', 's.id')
                ->leftJoin('shared_hosting as sh', 'p.service_id', '=', 'sh.id')
                ->leftJoin('reseller_hosting as r', 'p.service_id', '=', 'r.id')
                ->leftJoin('domains as d', 'p.service_id', '=', 'd.id')
                ->leftJoin('misc_services as ms', 'p.service_id', '=', 'ms.id')
                ->leftJoin('seedboxes as sb', 'p.service_id', '=', 'sb.id')
                ->where('p.active', '=', 1)
                ->orderBy('next_due_date', 'ASC')
                ->limit(Session::get('due_soon_amount'))
                ->get(['p.*', 's.hostname', 'd.domain', 'd.extension', 'r.main_domain as reseller', 'sh.main_domain', 'ms.name', 'sb.title']);
        });
    }

    public static function serverSummary()
    {
        return Cache::remember('servers_summary', now()->addHour(6), function () {
            $cpu_sum = DB::table('servers')->get()->where('active', '=', 1)->sum('cpu');
            $ram_mb = DB::table('servers')->get()->where('active', '=', 1)->sum('ram_as_mb');
            $disk_gb = DB::table('servers')->get()->where('active', '=', 1)->sum('disk_as_gb');
            $bandwidth = DB::table('servers')->get()->where('active', '=', 1)->sum('bandwidth');
            $locations_sum = DB::table('servers')->get()->where('active', '=', 1)->groupBy('location_id')->count();
            $providers_sum = DB::table('servers')->get()->where('active', '=', 1)->groupBy('provider_id')->count();
            return array(
                'cpu_sum' => $cpu_sum,
                'ram_mb_sum' => $ram_mb,
                'disk_gb_sum' => $disk_gb,
                'bandwidth_sum' => $bandwidth,
                'locations_sum' => $locations_sum,
                'providers_sum' => $providers_sum,
            );
        });
    }

    public static function recentlyAdded()
    {
        return Cache::remember('recently_added', now()->addHour(6), function () {
            return DB::table('pricings as p')
                ->leftJoin('servers as s', 'p.service_id', '=', 's.id')
                ->leftJoin('shared_hosting as sh', 'p.service_id', '=', 'sh.id')
                ->leftJoin('reseller_hosting as r', 'p.service_id', '=', 'r.id')
                ->leftJoin('domains as d', 'p.service_id', '=', 'd.id')
                ->leftJoin('misc_services as ms', 'p.service_id', '=', 'ms.id')
                ->leftJoin('seedboxes as sb', 'p.service_id', '=', 'sb.id')
                ->where('p.active', '=', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(Session::get('recently_added_amount'))
                ->get(['p.*', 's.hostname', 'd.domain', 'd.extension', 'r.main_domain as reseller', 'sh.main_domain', 'ms.name', 'sb.title']);
        });
    }

    public static function doDueSoon($due_soon)
    {
        $pricing = new Pricing();
        $count = $altered_due_soon = 0;
        foreach ($due_soon as $service) {
            if (Carbon::createFromFormat('Y-m-d', $service->next_due_date)->isPast()) {
                $months = $pricing->termAsMonths($service->term);//Get months for term to update the next due date to
                $new_due_date = Carbon::createFromFormat('Y-m-d', $service->next_due_date)->addMonths($months)->format('Y-m-d');
                DB::table('pricings')//Update the DB
                ->where('service_id', $service->service_id)
                    ->update(['next_due_date' => $new_due_date]);
                $due_soon[$count]->next_due_date = $new_due_date;//Update array being sent to view
                $altered_due_soon = 1;
            } else {
                break;//Break because if this date isnt past than the ones after it in the loop wont be either
            }
            $count++;
        }

        if ($altered_due_soon === 1) {//Made changes to due soon so re-write it
            Cache::put('due_soon', $due_soon);
        }

        return $due_soon;
    }

    public static function breakdownPricing($all_pricing): array
    {
        $pricing = json_decode($all_pricing, true);

        $total_cost_weekly = $total_cost_pm = $inactive_count = 0;
        foreach ($pricing as $price) {
            if ($price['active'] === 1) {
                if (Session::get('dashboard_currency') !== 'USD') {
                    $the_price = Pricing::convertFromUSD($price['as_usd'], Session::get('dashboard_currency'));
                } else {
                    $the_price = $price['as_usd'];
                }
                if ($price['term'] === 1) {//1 month
                    $total_cost_weekly += ($the_price / 4);
                    $total_cost_pm += $the_price;
                } elseif ($price['term'] === 2) {//3 months
                    $total_cost_weekly += ($the_price / 12);
                    $total_cost_pm += ($the_price / 3);
                } elseif ($price['term'] === 3) {// 6 month
                    $total_cost_weekly += ($the_price / 24);
                    $total_cost_pm += ($the_price / 6);
                } elseif ($price['term'] === 4) {// 1 year
                    $total_cost_weekly += ($the_price / 48);
                    $total_cost_pm += ($the_price / 12);
                } elseif ($price['term'] === 5) {//2 years
                    $total_cost_weekly += ($the_price / 96);
                    $total_cost_pm += ($the_price / 24);
                } elseif ($price['term'] === 6) {//3 years
                    $total_cost_weekly += ($the_price / 144);
                    $total_cost_pm += ($the_price / 36);
                }
            } else {
                $inactive_count++;
            }
        }
        $total_cost_yearly = ($total_cost_pm * 12);

        return array(
            'total_cost_weekly' => $total_cost_weekly,
            'total_cost_montly' => $total_cost_pm,
            'total_cost_yearly' => $total_cost_yearly,
            'inactive_count' => $inactive_count,
        );
    }

    public static function doServicesCount($services_count): array
    {
        $servers_count = $domains_count = $shared_count = $reseller_count = $other_count = $seedbox_count = $total_services = 0;

        $services_count = json_decode($services_count, true);

        foreach ($services_count as $sc) {
            $total_services += $sc['amount'];
            if ($sc['service_type'] === 1) {
                $servers_count = $sc['amount'];
            } else if ($sc['service_type'] === 2) {
                $shared_count = $sc['amount'];
            } else if ($sc['service_type'] === 3) {
                $reseller_count = $sc['amount'];
            } else if ($sc['service_type'] === 4) {
                $domains_count = $sc['amount'];
            } else if ($sc['service_type'] === 5) {
                $other_count = $sc['amount'];
            } else if ($sc['service_type'] === 6) {
                $seedbox_count = $sc['amount'];
            }
        }

        return array(
            'servers' => $servers_count,
            'shared' => $shared_count,
            'reseller' => $reseller_count,
            'domains' => $domains_count,
            'other' => $other_count,
            'seedbox' => $seedbox_count,
            'total' => $total_services
        );
    }


}
