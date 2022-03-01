<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Process;
use Illuminate\Support\Facades\Session;

//Custom code example

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $p = new Process();
        $p->startTimer();

        $services_count = Cache::remember('services_count', 1440, function () {
            return DB::table('pricings')
                ->select('service_type', DB::raw('COUNT(*) as amount'))
                ->groupBy('service_type')
                ->where('active', '=', 1)
                ->get();
        });

        $due_soon = Cache::remember('due_soon', 1440, function () {
            return DB::table('pricings as p')
                ->leftJoin('servers as s', 'p.service_id', '=', 's.id')
                ->leftJoin('shared_hosting as sh', 'p.service_id', '=', 'sh.id')
                ->leftJoin('reseller_hosting as r', 'p.service_id', '=', 'r.id')
                ->leftJoin('domains as d', 'p.service_id', '=', 'd.id')
                ->leftJoin('misc_services as ms', 'p.service_id', '=', 'ms.id')
                ->where('p.active', '=', 1)
                ->orderBy('next_due_date', 'ASC')
                ->limit(6)
                ->get(['p.*', 's.hostname', 'd.domain', 'd.extension', 'r.main_domain as reseller', 'sh.main_domain', 'ms.name']);
        });


        //Check for past due date and refresh the due date if so:
        $pricing = new Pricing();
        $count = 0;
        foreach ($due_soon as $service) {
            if (Carbon::createFromFormat('Y-m-d', $service->next_due_date)->isPast()) {
                $months = $pricing->termAsMonths($service->term);//Get months for term to update the next due date to
                $new_due_date = Carbon::createFromFormat('Y-m-d', $service->next_due_date)->addMonths($months)->format('Y-m-d');
                DB::table('pricings')//Update the DB
                ->where('service_id', $service->service_id)
                    ->update(['next_due_date' => $new_due_date]);
                $due_soon[$count]->next_due_date = $new_due_date;//Update array being sent to view
            } else {
                break;//Break because if this date isnt past than the ones after it in the loop wont be either
            }
            $count++;
        }

        Cache::put('due_soon', $due_soon);

        $recently_added = Cache::remember('recently_added', 1440, function () {
            return DB::table('pricings as p')
                ->leftJoin('servers as s', 'p.service_id', '=', 's.id')
                ->leftJoin('shared_hosting as sh', 'p.service_id', '=', 'sh.id')
                ->leftJoin('reseller_hosting as r', 'p.service_id', '=', 'r.id')
                ->leftJoin('domains as d', 'p.service_id', '=', 'd.id')
                ->leftJoin('misc_services as ms', 'p.service_id', '=', 'ms.id')
                ->where('p.active', '=', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get(['p.*', 's.hostname', 'd.domain', 'd.extension', 'r.main_domain as reseller', 'sh.main_domain', 'ms.name']);
        });

        $settings = Cache::remember('settings', 15, function () {
            return DB::table('settings')
                ->where('id', '=', 1)
                ->get();
        });

        Session::put('timer_version_footer', $settings[0]->show_versions_footer);
        Session::put('show_servers_public', $settings[0]->show_servers_public);
        Session::save();

        $pricing = json_decode(DB::table('pricings')->get(), true);

        $total_cost_weekly = $total_cost_pm = $inactive_count = 0;
        foreach ($pricing as $price) {
            if ($price['active'] === 1) {
                if ($price['term'] === 1) {//1 month
                    $total_cost_weekly += ($price['as_usd'] / 4);
                    $total_cost_pm += $price['as_usd'];
                } elseif ($price['term'] === 2) {//3 months
                    $total_cost_weekly += ($price['as_usd'] / 12);
                    $total_cost_pm += ($price['as_usd'] / 3);
                } elseif ($price['term'] === 3) {// 6 month
                    $total_cost_weekly += ($price['as_usd'] / 24);
                    $total_cost_pm += ($price['as_usd'] / 6);
                } elseif ($price['term'] === 4) {// 1 year
                    $total_cost_weekly += ($price['as_usd'] / 48);
                    $total_cost_pm += ($price['as_usd'] / 12);
                } elseif ($price['term'] === 5) {//2 years
                    $total_cost_weekly += ($price['as_usd'] / 96);
                    $total_cost_pm += ($price['as_usd'] / 24);
                } elseif ($price['term'] === 6) {//3 years
                    $total_cost_weekly += ($price['as_usd'] / 144);
                    $total_cost_pm += ($price['as_usd'] / 36);
                }
            } else {
                $inactive_count++;
            }
        }
        $total_cost_yearly = ($total_cost_pm * 12);

        $services_count = json_decode($services_count, true);

        $servers_count = $domains_count = $shared_count = $reseller_count = $other_count = $total_services = 0;

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
            }
        }

        $p->stopTimer();

        $information = array(
            'servers' => $servers_count,
            'domains' => $domains_count,
            'shared' => $shared_count,
            'reseller' => $reseller_count,
            'misc' => $other_count,
            'labels' => DB::table('labels')->count(),
            'dns' => DB::table('d_n_s')->count(),
            'total_services' => $total_services,
            'total_inactive' => $inactive_count,
            'total_cost_weekly' => number_format($total_cost_weekly, 2),
            'total_cost_monthly' => number_format($total_cost_pm, 2),
            'total_cost_yearly' => number_format($total_cost_yearly, 2),
            'total_cost_2_yearly' => number_format(($total_cost_yearly * 2), 2),
            'due_soon' => $due_soon,
            'newest' => $recently_added,
            'execution_time' => number_format($p->getTimeTaken(), 2)
        );

        return view('home', compact('information'));
    }
}
