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

        //Get & set the settings, 1 minute cache
        $settings = Settings::getSettings();
        Settings::setSettingsToSession($settings);

        //Check for past due date and refresh the due date if so:
        $due_soon = Home::doDueSoon(Home::dueSoonData());

        //Orders services most recently added first, cached with limit from settings
        $recently_added = Home::recentlyAdded();

        //Get count tally for each of the services type
        $service_count = Home::doServicesCount(Home::servicesCount());

        //Get pricing for weekly, monthly, yearly, 2 yearly
        $pricing_breakdown = Home::breakdownPricing(Pricing::allPricing());

        //Summary of servers specs
        $server_summary = Home::serverSummary();

        $p->stopTimer();

        $information = [
            'servers' => $service_count['servers'],
            'domains' => $service_count['domains'],
            'shared' => $service_count['shared'],
            'reseller' => $service_count['reseller'],
            'misc' => $service_count['other'],
            'seedbox' => $service_count['seedbox'],
            'labels' => Labels::labelsCount(),
            'dns' => DNS::dnsCount(),
            'total_services' => $service_count['total'],
            'total_inactive' => $pricing_breakdown['inactive_count'],
            'total_cost_weekly' => number_format($pricing_breakdown['total_cost_weekly'], 2),
            'total_cost_monthly' => number_format($pricing_breakdown['total_cost_montly'], 2),
            'total_cost_yearly' => number_format($pricing_breakdown['total_cost_yearly'], 2),
            'total_cost_2_yearly' => number_format(($pricing_breakdown['total_cost_yearly'] * 2), 2),
            'due_soon' => $due_soon,
            'newest' => $recently_added,
            'execution_time' => number_format($p->getTimeTaken(), 2),
            'servers_summary' => $server_summary,
            'currency' => Session::get('dashboard_currency')
        ];

        return view('home', compact('information'));
    }
}
