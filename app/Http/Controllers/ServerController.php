<?php

namespace App\Http\Controllers;

use App\Models\IPs;
use App\Models\Labels;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Server;
use App\Models\Providers;
use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServerController extends Controller
{

    public function index()
    {
        $servers = Cache::remember('all_active_servers', 1440, function () {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->join('os as o', 's.os_id', '=', 'o.id')
                ->where('s.active', '=', 1)
                ->get(['s.*', 'pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'pr.next_due_date', 'p.name as provider_name', 'l.name as location', 'o.name as os_name']);
        });

        $non_active_servers = Cache::remember('non_active_servers', 1440, function () {
            return DB::table('servers as s')
                ->join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->join('providers as p', 's.provider_id', '=', 'p.id')
                ->join('locations as l', 's.location_id', '=', 'l.id')
                ->join('os as o', 's.os_id', '=', 'o.id')
                ->where('s.active', '=', 0)
                ->get(['s.*', 'pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'p.name as provider_name', 'l.name as location', 'o.name as os_name']);
        });

        return view('servers.index', compact(['servers', 'non_active_servers']));
    }

    public function showServersPublic()
    {
        $settings = DB::table('settings')
            ->where('id', '=', 1)
            ->get();

        Session::put('timer_version_footer', $settings[0]->show_versions_footer ?? 1);
        Session::put('show_servers_public', $settings[0]->show_servers_public ?? 0);
        Session::put('show_server_value_ip', $settings[0]->show_server_value_ip ?? 0);
        Session::put('show_server_value_hostname', $settings[0]->show_server_value_hostname ?? 0);
        Session::put('show_server_value_price', $settings[0]->show_server_value_price ?? 0);
        Session::put('show_server_value_yabs', $settings[0]->show_server_value_yabs ?? 0);
        Session::put('show_server_value_provider', $settings[0]->show_server_value_provider ?? 0);
        Session::put('show_server_value_location', $settings[0]->show_server_value_location ?? 0);
        Session::save();

        if ((Session::get('show_servers_public') === 1)) {
            $servers = DB::table('servers as s')
                ->Join('pricings as pr', 's.id', '=', 'pr.service_id')
                ->Join('providers as p', 's.provider_id', '=', 'p.id')
                ->Join('locations as l', 's.location_id', '=', 'l.id')
                ->Join('os as o', 's.os_id', '=', 'o.id')
                ->LeftJoin('ips as i', 's.id', '=', 'i.service_id')
                ->LeftJoin('yabs as y', 's.id', '=', 'y.server_id')
                ->LeftJoin('disk_speed as ds', 'y.id', '=', 'ds.id')
                ->where('s.show_public', '=', 1)
                ->get(['pr.currency', 'pr.price', 'pr.term', 'pr.as_usd', 'pr.next_due_date', 'pr.service_id', 'p.name as provider_name', 'l.name as location', 'o.name as os_name', 'y.*', 'y.id as yabs_id', 'ds.*', 's.*', 'i.address as ip', 'i.is_ipv4']);

            return view('servers.public-index', compact('servers'));
        }
        return response()->view('errors.404', array("status" => 404, "title" => "Page not found", "message" => ""), 404);
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'hostname' => 'required|min:5',
            'ip1' => 'nullable|ip',
            'ip2' => 'nullable|ip',
            'service_type' => 'numeric',
            'server_type' => 'numeric',
            'ram' => 'numeric',
            'disk' => 'numeric',
            'os_id' => 'numeric',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'cpu' => 'numeric',
            'was_promo' => 'numeric',
            'next_due_date' => 'required|date'
        ]);

        $server_id = Str::random(8);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        Pricing::create([
            'service_id' => $server_id,
            'service_type' => 1,
            'currency' => $request->currency,
            'price' => $request->price,
            'term' => $request->payment_term,
            'as_usd' => $as_usd,
            'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
            'next_due_date' => $request->next_due_date,
        ]);

        if (!is_null($request->ip1)) {
            IPs::insertIP($server_id, $request->ip1);
        }

        if (!is_null($request->ip2)) {
            IPs::insertIP($server_id, $request->ip2);
        }

        Server::create([
            'id' => $server_id,
            'hostname' => $request->hostname,
            'server_type' => $request->server_type,
            'os_id' => $request->os_id,
            'ssh' => $request->ssh_port,
            'provider_id' => $request->provider_id,
            'location_id' => $request->location_id,
            'ram' => $request->ram,
            'ram_type' => $request->ram_type,
            'ram_as_mb' => ($request->ram_type === 'MB') ? $request->ram : ($request->ram * 1024),
            'disk' => $request->disk,
            'disk_type' => $request->disk_type,
            'disk_as_gb' => ($request->disk_type === 'GB') ? $request->disk : ($request->disk * 1024),
            'owned_since' => $request->owned_since,
            'ns1' => $request->ns1,
            'ns2' => $request->ns2,
            'bandwidth' => $request->bandwidth,
            'cpu' => $request->cpu,
            'was_promo' => $request->was_promo,
            'show_public' => (isset($request->show_public)) ? 1 : 0
        ]);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $server_id);

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache
        Cache::forget('servers_summary');//servers summary cache

        return redirect()->route('servers.index')
            ->with('success', 'Server Created Successfully.');
    }

    public function show(Server $server)
    {
        $server_extras = DB::table('servers as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('os as o', 's.os_id', '=', 'o.id')
            ->Leftjoin('yabs as y', 's.id', '=', 'y.server_id')
            ->Leftjoin('disk_speed as ds', 'y.id', '=', 'ds.id')
            ->where('s.id', '=', $server->id)
            ->get(['s.*', 'p.name as provider', 'l.name as location', 'o.name as os_name', 'pr.*', 'y.*', 'ds.*']);

        $network_speeds = json_decode(DB::table('network_speed')
            ->where('network_speed.server_id', '=', $server->id)
            ->get(), true);

        $ip_addresses = json_decode(DB::table('ips as i')
            ->where('i.service_id', '=', $server->id)
            ->get(), true);

        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $server->id)
            ->get(['labels.label']);

        return view('servers.show', compact(['server', 'server_extras', 'network_speeds', 'labels', 'ip_addresses']));
    }

    public function edit(Server $server)
    {
        $ip_addresses = json_decode(DB::table('ips as i')
            ->where('i.service_id', '=', $server->id)
            ->get(), true);

        $server = DB::table('servers as s')
            ->join('pricings as p', 's.id', '=', 'p.service_id')
            ->where('s.id', '=', $server->id)
            ->get(['s.*', 'p.*']);

        return view('servers.edit', compact(['server','ip_addresses']));
    }

    public function update(Request $request, Server $server)
    {
        $request->validate([
            'hostname' => 'required|min:5',
            'ram' => 'numeric',
            'disk' => 'numeric',
            'os_id' => 'numeric',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'cpu' => 'numeric',
            'was_promo' => 'numeric',
            'next_due_date' => 'date'
        ]);

        $server_id = $request->server_id;

        DB::table('servers')
            ->where('id', $server_id)
            ->update([
                'hostname' => $request->hostname,
                'server_type' => $request->server_type,
                'os_id' => $request->os_id,
                'ssh' => $request->ssh,
                'provider_id' => $request->provider_id,
                'location_id' => $request->location_id,
                'ram' => $request->ram,
                'ram_type' => $request->ram_type,
                'ram_as_mb' => ($request->ram_type === 'MB') ? $request->ram : ($request->ram * 1024),
                'disk' => $request->disk,
                'disk_type' => $request->disk_type,
                'disk_as_gb' => ($request->disk_type === 'GB') ? $request->disk : ($request->disk * 1024),
                'owned_since' => $request->owned_since,
                'ns1' => $request->ns1,
                'ns2' => $request->ns2,
                'bandwidth' => $request->bandwidth,
                'cpu' => $request->cpu,
                'was_promo' => $request->was_promo,
                'active' => (isset($request->is_active)) ? 1 : 0,
                'show_public' => (isset($request->show_public)) ? 1 : 0
            ]);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        DB::table('pricings')
            ->where('service_id', $server_id)
            ->update([
                'service_type' => 1,
                'currency' => $request->currency,
                'price' => $request->price,
                'term' => $request->payment_term,
                'as_usd' => $as_usd,
                'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
                'next_due_date' => $request->next_due_date,
                'active' => (isset($request->is_active)) ? 1 : 0
            ]);

        Labels::deleteLabelsAssignedTo($server_id);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $server_id);

        IPs::deleteIPsAssignedTo($server_id);

        for ($i = 1; $i <= 8; $i++) {//Max of 8 ips
            $obj = 'ip' . $i;
            if (isset($request->$obj) && !is_null($request->$obj)) {
                IPs::insertIP($server_id, $request->$obj);
            }
        }

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache
        Cache::forget('servers_summary');//servers summary cache

        return redirect()->route('servers.index')
            ->with('success', 'Server Updated Successfully.');
    }

    public function destroy(Server $server)
    {
        $items = Server::find($server->id);

        $items->delete();

        $p = new Pricing();
        $p->deletePricing($server->id);

        Labels::deleteLabelsAssignedTo($server->id);

        IPs::deleteIPsAssignedTo($server->id);

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache
        Cache::forget('servers_summary');//servers summary cache

        return redirect()->route('servers.index')
            ->with('success', 'Server was deleted Successfully.');
    }

    public function chooseCompare()
    {
        $all_servers = Server::where('has_yabs', 1)->get();
        return view('servers.choose-compare', compact('all_servers'));
    }

    public function compareServers($server1, $server2)
    {
        $server1_data = DB::table('servers as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->Join('yabs as y', 's.id', '=', 'y.server_id')
            ->Join('disk_speed as ds', 'y.id', '=', 'ds.id')
            ->where('s.id', '=', $server1)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*', 'y.*', 'y.id as yabs_id', 'ds.*']);

        if (count($server1_data) === 0) {
            return response()->view('errors.404', array("status" => 404, "title" => "Page not found", "message" => "No server with YABs data was found for id '$server1'"), 404);
        }

        $server1_network = DB::table('network_speed')
            ->where('id', '=', $server1_data[0]->yabs_id)
            ->get();

        $server2_data = DB::table('servers as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->Join('yabs as y', 's.id', '=', 'y.server_id')
            ->Join('disk_speed as ds', 'y.id', '=', 'ds.id')
            ->where('s.id', '=', $server2)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*', 'y.*', 'y.id as yabs_id', 'ds.*']);

        if (count($server2_data) === 0) {
            return response()->view('errors.404', array("status" => 404, "title" => "Page not found", "message" => "No server with YABs data was found for id '$server2'"), 404);
        }

        $server2_network = DB::table('network_speed')
            ->where('id', '=', $server2_data[0]->yabs_id)
            ->get();

        return view('servers.compare', compact('server1_data', 'server2_data', 'server1_network', 'server2_network'));
    }
}
