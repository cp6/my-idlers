<?php

namespace App\Http\Controllers;

use App\Models\DNS;
use App\Models\Home;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Process;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $p = new Process();
        $p->startTimer();

        $services_count = Home::servicesCount();

        $due_soon = Home::dueSoonData();

        $server_summary = Home::serverSummary();

        //Check for past due date and refresh the due date if so:
        $due_soon = Home::doDueSoon($due_soon);

        $recently_added = Home::recentlyAdded();

        $settings = Settings::getSettings();

        Settings::setSettingsToSession($settings);

        $all_pricing = Pricing::allPricing();

        $services_count = json_decode($services_count, true);

        $servers_count = $domains_count = $shared_count = $reseller_count = $other_count = $seedbox_count = $total_services = 0;

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

        $pricing_breakdown = Home::breakdownPricing($all_pricing);

        $p->stopTimer();

        $information = array(
            'servers' => $servers_count,
            'domains' => $domains_count,
            'shared' => $shared_count,
            'reseller' => $reseller_count,
            'misc' => $other_count,
            'seedbox' => $seedbox_count,
            'labels' => Labels::labelsCount(),
            'dns' => DNS::dnsCount(),
            'total_services' => $total_services,
            'total_inactive' => $pricing_breakdown['inactive_count'],
            'total_cost_weekly' => number_format($pricing_breakdown['total_cost_weekly'], 2),
            'total_cost_monthly' => number_format($pricing_breakdown['total_cost_montly'], 2),
            'total_cost_yearly' => number_format($pricing_breakdown['total_cost_yearly'], 2),
            'total_cost_2_yearly' => number_format(($pricing_breakdown['total_cost_yearly'] * 2), 2),
            'due_soon' => $due_soon,
            'newest' => $recently_added,
            'execution_time' => number_format($p->getTimeTaken(), 2),
            'servers_summary' => $server_summary
        );

        return view('home', compact('information'));
    }
}
