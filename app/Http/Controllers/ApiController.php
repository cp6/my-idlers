<?php

namespace App\Http\Controllers;

use App\Models\DiskSpeed;
use App\Models\Domains;
use App\Models\IPs;
use App\Models\Labels;
use App\Models\Misc;
use App\Models\NetworkSpeed;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Reseller;
use App\Models\SeedBoxes;
use App\Models\Server;
use App\Models\Shared;
use App\Models\Yabs;
use App\Process;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    protected function getAllServers()
    {
        $servers = Server::allServers()->toJson(JSON_PRETTY_PRINT);
        return response($servers, 200);
    }

    protected function getServer($id)
    {
        $server = Server::server($id)->toJson(JSON_PRETTY_PRINT);
        return response($server, 200);
    }

    protected function getAllPricing()
    {
        $pricing = Pricing::all()->toJson(JSON_PRETTY_PRINT);
        return response($pricing, 200);
    }

    protected function getPricing($id)
    {
        $pricing = Pricing::where('id', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($pricing, 200);
    }

    protected function getAllNetworkSpeeds()
    {
        $ns = NetworkSpeed::all()->toJson(JSON_PRETTY_PRINT);
        return response($ns, 200);
    }

    protected function getNetworkSpeeds($id)
    {
        $ns = NetworkSpeed::where('server_id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($ns, 200);
    }

    protected function getAllLabels()
    {
        $labels = Labels::all()->toJson(JSON_PRETTY_PRINT);
        return response($labels, 200);
    }

    protected function getLabel($id)
    {
        $label = Labels::where('id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($label, 200);
    }

    protected function getAllShared()
    {
        $shared = Shared::allSharedHosting()->toJson(JSON_PRETTY_PRINT);
        return response($shared, 200);
    }

    protected function getShared($id)
    {
        $shared = Shared::sharedHosting($id)->toJson(JSON_PRETTY_PRINT);
        return response($shared, 200);
    }

    protected function getAllReseller()
    {
        $reseller = Reseller::allResellerHosting()->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getReseller($id)
    {
        $reseller = Reseller::resellerHosting($id)->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getAllSeedbox()
    {
        $reseller = SeedBoxes::allSeedboxes()->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getSeedbox($id)
    {
        $reseller = SeedBoxes::seedbox($id)->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getAllDomains()
    {
        $domains = Domains::allDomains()->toJson(JSON_PRETTY_PRINT);
        return response($domains, 200);
    }

    protected function getDomains($id)
    {
        $domain = Domains::domain($id)->toJson(JSON_PRETTY_PRINT);
        return response($domain, 200);
    }

    protected function getAllMisc()
    {
        $misc = Misc::allMisc()->toJson(JSON_PRETTY_PRINT);
        return response($misc, 200);
    }

    protected function getMisc($id)
    {
        $misc = Misc::misc($id)->toJson(JSON_PRETTY_PRINT);
        return response($misc, 200);
    }

    protected function getAllDns()
    {
        $dns = DB::table('d_n_s')
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($dns, 200);
    }

    protected function getDns($id)
    {
        $dns = DB::table('d_n_s')
            ->where('id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($dns, 200);
    }

    protected function getAllLocations()
    {
        $locations = DB::table('locations')
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($locations, 200);
    }

    protected function getLocation($id)
    {
        $location = DB::table('locations')
            ->where('id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($location, 200);
    }

    protected function getAllProviders()
    {
        $providers = DB::table('providers')
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($providers, 200);
    }

    protected function getProvider($id)
    {
        $providers = DB::table('providers')
            ->where('id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($providers, 200);
    }

    protected function getAllSettings()
    {
        $settings = DB::table('settings')
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($settings, 200);
    }

    protected function getAllOs()
    {
        $os = OS::allOS()->toJson(JSON_PRETTY_PRINT);
        return response($os, 200);
    }

    protected function getOs($id)
    {
        $os = DB::table('os as o')
            ->where('o.id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($os, 200);
    }

    protected function getAllIPs()
    {
        $ip = IPs::all()->toJson(JSON_PRETTY_PRINT);
        return response($ip, 200);
    }

    protected function getIP($id)
    {
        $ip = DB::table('ips as i')
            ->where('i.id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($ip, 200);
    }

    public function getAllProvidersTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Providers::latest()->get();
            $dt = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<form action="' . route('providers.destroy', $row['id']) . '" method="POST"><i class="fas fa-trash text-danger ms-3" @click="modalForm" id="btn-' . $row['name'] . '" title="' . $row['id'] . '"></i> </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $dt;
        }
    }

    protected function checkHostIsUp(string $hostname)
    {//Check if host/ip is "up"
        ($fp = @fsockopen($hostname, 80, $errCode, $errStr, 1)) ? $result = true : $result = false;
        if ($fp) {
            @fclose($fp);
        }
        return response(array('is_online' => $result), 200);
    }

    protected function getIpForDomain(string $domainname, string $type)
    {//Gets IP from A record for a domain
        switch ($type) {
            case "A":
                $data = dns_get_record($domainname, DNS_A);
                if (isset($data['0']['ip'])) {
                    return response(array('ip' => $data['0']['ip']), 200);
                }
                break;
            case "AAAA":
                $data = dns_get_record($domainname, DNS_AAAA);
                if (isset($data['0']['ipv6'])) {
                    return response(array('ip' => $data['0']['ipv6']), 200);
                }
                break;
        }
        return response(array('ip' => null), 200);
    }

    protected function storeServer(Request $request)
    {
        $rules = array(
            'hostname' => 'min:3',
            'server_type' => 'required|integer',
            'os_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'location_id' => 'required|integer',
            'ssh_port' => 'required|integer',
            'ram' => 'required|integer',
            'ram_as_mb' => 'required|integer',
            'disk' => 'required|integer',
            'disk_as_gb' => 'required|integer',
            'cpu' => 'required|integer',
            'bandwidth' => 'required|integer',
            'was_promo' => 'required|integer',
            'active' => 'required|integer',
            'show_public' => 'required|integer',
            'ip1' => 'ip',
            'ip2' => 'ip',
            'owned_since' => 'required|date',
            'ram_type' => 'required|string|size:2',
            'disk_type' => 'required|string|size:2',
            'currency' => 'required|string|size:3',
            'price' => 'required|numeric',
            'payment_term' => 'required|integer',
            'next_due_date' => 'date',
        );

        $messages = array(
            'required' => ':attribute is required',
            'min' => ':attribute must be longer than 3',
            'integer' => ':attribute must be an integer',
            'string' => ':attribute must be a string',
            'size' => ':attribute must be exactly :size characters',
            'numeric' => ':attribute must be a float',
            'ip' => ':attribute must be a valid IP address',
            'date' => ':attribute must be a date Y-m-d',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['result' => 'fail', 'messages' => $validator->messages()], 400);
        }

        $server_id = Str::random(8);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        $pricing->insertPricing(1, $server_id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        if (!is_null($request->ip1)) {
            IPs::insertIP($server_id, $request->ip1);
        }

        if (!is_null($request->ip2)) {
            IPs::insertIP($server_id, $request->ip2);
        }

        $insert = Server::create([
            'id' => $server_id,
            'hostname' => $request->hostname,
            'server_type' => $request->server_type,
            'os_id' => $request->os_id,
            'ssh_port' => $request->ssh_port,
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

        Server::serverRelatedCacheForget();

        if ($insert) {
            return response()->json(array('result' => 'success', 'server_id' => $server_id), 200);
        }

        return response()->json(array('result' => 'fail', 'request' => $request->post()), 500);
    }

    public function destroyServer(Request $request)
    {
        $items = Server::find($request->id);

        (!is_null($items)) ? $result = $items->delete() : $result = false;

        $p = new Pricing();
        $p->deletePricing($request->id);

        Labels::deleteLabelsAssignedTo($request->id);
        IPs::deleteIPsAssignedTo($request->id);
        Server::serverRelatedCacheForget();

        if ($result) {
            return response()->json(array('result' => 'success'), 200);
        }

        return response()->json(array('result' => 'fail'), 500);
    }

    public function updateServer(Request $request)
    {
        $rules = array(
            'hostname' => 'string|min:3',
            'server_type' => 'integer',
            'os_id' => 'integer',
            'provider_id' => 'integer',
            'location_id' => 'integer',
            'ssh_port' => 'integer',
            'ram' => 'integer',
            'ram_as_mb' => 'integer',
            'disk' => 'integer',
            'disk_as_gb' => 'integer',
            'cpu' => 'integer',
            'bandwidth' => 'integer',
            'was_promo' => 'integer',
            'active' => 'integer',
            'show_public' => 'integer',
            'owned_since' => 'date',
            'ram_type' => 'string|size:2',
            'disk_type' => 'string|size:2',
            'currency' => 'string|size:3',
            'price' => 'numeric',
            'payment_term' => 'integer',
            'next_due_date' => 'date',
        );

        $messages = array(
            'required' => ':attribute is required',
            'min' => ':attribute must be longer than 3',
            'integer' => ':attribute must be an integer',
            'string' => ':attribute must be a string',
            'size' => ':attribute must be exactly :size characters',
            'numeric' => ':attribute must be a float',
            'date' => ':attribute must be a date Y-m-d',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['result' => 'fail', 'messages' => $validator->messages()], 400);
        }

        $server_update = Server::where('id', $request->id)->update(request()->all());

        Server::serverRelatedCacheForget();
        Server::serverSpecificCacheForget($request->id);

        if ($server_update) {
            return response()->json(array('result' => 'success', 'server_id' => $request->id), 200);
        }

        return response()->json(array('result' => 'fail', 'request' => $request->post()), 500);
    }

    public function updatePricing(Request $request)
    {
        $rules = array(
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'term' => 'required|integer',
            'active' => 'integer',
            'next_due_date' => 'date',
        );

        $messages = array(
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'string' => ':attribute must be a string',
            'size' => ':attribute must be exactly :size characters',
            'numeric' => ':attribute must be a float',
            'date' => ':attribute must be a date Y-m-d',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['result' => 'fail', 'messages' => $validator->messages()], 400);
        }

        $pricing = new Pricing();

        $request->as_usd = $pricing->convertToUSD($request->price, $request->currency);

        $request->usd_per_month = $pricing->costAsPerMonth($request->as_usd, $request->term);

        $price_update = Pricing::where('id', $request->id)->update(request()->all());

        Cache::forget("all_pricing");
        Server::serverRelatedCacheForget();

        if ($price_update) {
            return response()->json(array('result' => 'success', 'server_id' => $request->id), 200);
        }

        return response()->json(array('result' => 'fail', 'request' => $request->post()), 500);
    }

    public function storeYabs(Request $request)
    {
        $rules = array(
            'server_id' => 'required|string|size:8',
            'yabs_output' => 'required|string',
        );

        $messages = array(
            'required' => ':attribute is required',
            'string' => ':attribute must be a string',
            'size' => ':attribute must be exactly :size characters'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['result' => 'fail', 'messages' => $validator->messages()], 400);
        }

        //dd($request->all());
        $process = new Process();
        $yabs = $process->yabsOutputAsJson($request->server_id, $request->yabs_output);
        //dd($yabs);

        $yabs_id = Str::random(8);

        $yabs_insert = Yabs::create([
            'id' => $yabs_id,
            'server_id' => $request->server_id,
            'has_ipv6' => $yabs['has_ipv6'],
            'aes' => $yabs['aes'],
            'vm' => $yabs['vm'],
            'output_date' => $yabs['output_date'],
            'cpu_cores' => $yabs['cpu_cores'],
            'cpu_freq' => $yabs['cpu_freq'],
            'cpu_model' => $yabs['cpu'],
            'ram' => $yabs['ram'],
            'ram_type' => $yabs['ram_type'],
            'ram_mb' => $yabs['ram_mb'],
            'swap' => $yabs['swap'],
            'swap_type' => $yabs['swap_type'],
            'swap_mb' => $yabs['swap_mb'],
            'disk' => $yabs['disk'],
            'disk_type' => $yabs['disk_type'],
            'disk_gb' => $yabs['disk_gb'],
            'gb5_single' => $yabs['GB5_single'],
            'gb5_multi' => $yabs['GB5_mult'],
            'gb5_id' => $yabs['GB5_id'],
            'uptime' => $yabs['uptime'],
            'distro' => $yabs['distro'],
            'kernel' => $yabs['kernel']
        ]);

        DiskSpeed::create([
            'id' => $yabs_id,
            'server_id' => $request->server_id,
            'd_4k' => $yabs['disk_speed']['4k_total'],
            'd_4k_type' => $yabs['disk_speed']['4k_total_type'],
            'd_4k_as_mbps' => $yabs['disk_speed']['4k_total_mbps'],
            'd_64k' => $yabs['disk_speed']['64k_total'],
            'd_64k_type' => $yabs['disk_speed']['64k_total_type'],
            'd_64k_as_mbps' => $yabs['disk_speed']['64k_total_mbps'],
            'd_512k' => $yabs['disk_speed']['512k_total'],
            'd_512k_type' => $yabs['disk_speed']['512k_total_type'],
            'd_512k_as_mbps' => $yabs['disk_speed']['512k_total_mbps'],
            'd_1m' => $yabs['disk_speed']['1m_total'],
            'd_1m_type' => $yabs['disk_speed']['1m_total_type'],
            'd_1m_as_mbps' => $yabs['disk_speed']['1m_total_mbps']
        ]);

        foreach ($yabs['network_speed'] as $y) {
            NetworkSpeed::create([
                'id' => $yabs_id,
                'server_id' => $request->server_id,
                'location' => $y['location'],
                'send' => $y['send'],
                'send_type' => $y['send_type'],
                'send_as_mbps' => $y['send_type_mbps'],
                'receive' => $y['receive'],
                'receive_type' => $y['receive_type'],
                'receive_as_mbps' => $y['receive_type_mbps']
            ]);
        }

        $update_server = DB::table('servers')
            ->where('id', $request->server_id)
            ->update([
                'ram' => $yabs['ram'],
                'ram_type' => $yabs['ram_type'],
                'ram_as_mb' => ($yabs['ram_type'] === 'GB') ? ($yabs['ram'] * 1024) : $yabs['ram'],
                'disk' => $yabs['disk'],
                'disk_type' => $yabs['disk_type'],
                'disk_as_gb' => ($yabs['disk_type'] === 'TB') ? ($yabs['disk'] * 1024) : $yabs['disk'],
                'cpu' => $yabs['cpu_cores'],
                'has_yabs' => 1
            ]);

        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache
        Cache::forget('all_yabs');//Forget the all YABs cache

        if ($yabs_insert) {
            return response()->json(array('result' => 'success', 'yabs_id' => $yabs_id), 200);
        }

        return response()->json(array('result' => 'fail', 'request' => $request->post()), 500);

    }

    public function getAllYabs()
    {
        $yabs = Yabs::allYabs()->toJson(JSON_PRETTY_PRINT);
        return response($yabs, 200);
    }

    protected function getYabs($id)
    {
        $yabs = Yabs::yabs($id)->toJson(JSON_PRETTY_PRINT);
        return response($yabs, 200);
    }

}
