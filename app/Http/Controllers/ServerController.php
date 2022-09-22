<?php

namespace App\Http\Controllers;

use App\Models\IPs;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Server;
use App\Models\Settings;
use App\Models\Yabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{

    public function index()
    {
        $servers = Server::allActiveServers();

        $non_active_servers = Server::allNonActiveServers();

        return view('servers.index', compact(['servers', 'non_active_servers']));
    }

    public function showServersPublic()
    {
        $settings = Settings::getSettings();

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
            $servers = Server::allPublicServers();
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
        $pricing->insertPricing(1, $server_id, $request->currency, $request->price, $request->payment_term, $request->next_due_date);

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

        Server::serverRelatedCacheForget();

        return redirect()->route('servers.index')
            ->with('success', 'Server Created Successfully.');
    }

    public function show(Server $server)
    {
        $server_data = Server::server($server->id);

        return view('servers.show', compact(['server_data']));
    }

    public function edit(Server $server)
    {
        $server_data = Server::server($server->id);

        return view('servers.edit', compact(['server_data']));
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

        $pricing->updatePricing($server_id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        Labels::deleteLabelsAssignedTo($server_id);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $server_id);

        IPs::deleteIPsAssignedTo($server_id);

        for ($i = 1; $i <= 8; $i++) {//Max of 8 ips
            $obj = 'ip' . $i;
            if (isset($request->$obj) && !is_null($request->$obj)) {
                IPs::insertIP($server_id, $request->$obj);
            }
        }

        Server::serverRelatedCacheForget();
        Server::serverSpecificCacheForget($server_id);

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

        Server::serverRelatedCacheForget();

        return redirect()->route('servers.index')
            ->with('success', 'Server was deleted Successfully.');
    }

    public function chooseCompare()
    {//NOTICE: Selecting servers is not cached yet
        $all_servers = Server::where('has_yabs', 1)->get();
        return view('servers.choose-compare', compact('all_servers'));
    }

    public function compareServers($server1, $server2)
    {
        $server1_data = Server::server($server1);

        if (!isset($server1_data[0]->yabs[0])) {
            return response()->view('errors.404', array("status" => 404, "title" => "Page not found", "message" => "No server with YABs data was found for id '$server1'"), 404);
        }

        $server2_data = Server::server($server2);

        if (!isset($server2_data[0]->yabs[0])) {
            return response()->view('errors.404', array("status" => 404, "title" => "Page not found", "message" => "No server with YABs data was found for id '$server2'"), 404);
        }
        return view('servers.compare', compact('server1_data', 'server2_data'));
    }
}
