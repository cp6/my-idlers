<?php

namespace App\Http\Controllers;

use App\Models\IPs;
use App\Models\Labels;
use App\Models\NetworkSpeed;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Server;
use App\Models\Shared;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    protected function getAllServers()
    {
        $servers = DB::table('servers as s')
            ->Join('pricings as p', 's.id', '=', 'p.service_id')
            ->join('providers as pr', 's.provider_id', '=', 'pr.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('os as o', 's.os_id', '=', 'o.id')
            ->get(['s.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date', 'pr.name as provider', 'l.name as location', 'o.name as os'])->toJson(JSON_PRETTY_PRINT);

        return response($servers, 200);
    }

    protected function getServer($id)
    {
        $server = DB::table('servers as s')
            ->Join('pricings as p', 's.id', '=', 'p.service_id')
            ->join('providers as pr', 's.provider_id', '=', 'pr.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('os as o', 's.os_id', '=', 'o.id')
            ->where('s.id', '=', $id)
            ->get(['s.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date', 'pr.name as provider', 'l.name as location', 'o.name as os']);

        $yabs = DB::table('yabs')
            ->where('yabs.server_id', '=', $id)
            ->get();

        $disk_speed = DB::table('disk_speed')
            ->where('disk_speed.server_id', '=', $id)
            ->get();

        $network_speed = DB::table('network_speed')
            ->where('network_speed.server_id', '=', $id)
            ->get();

        $labels = DB::table('labels_assigned as la')
            ->Join('labels as l', 'la.label_id', '=', 'l.id')
            ->where('la.service_id', '=', $id)
            ->get(['l.*']);

        $ip_addresses = DB::table('ips as i')
            ->where('i.service_id', '=', $id)
            ->get(['i.*']);

        $server['ip_addresses'] = $ip_addresses;
        $server['yabs'] = $yabs;
        $server['disk_speed'] = $disk_speed;
        $server['network_speed'] = $network_speed;
        $server['labels'] = $labels;

        return response($server, 200);
    }

    protected function getAllPricing()
    {
        $pricing = Pricing::all()->toJson(JSON_PRETTY_PRINT);
        return response($pricing, 200);
    }

    protected function getPricing($id)
    {
        $pricing = Pricing::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($pricing, 200);
    }

    protected function getAllNetworkSpeeds()
    {
        $ns = NetworkSpeed::all()->toJson(JSON_PRETTY_PRINT);
        return response($ns, 200);
    }

    protected function getNetworkSpeeds($id)
    {
        $ns = DB::table('network_speed as n')
            ->where('n.server_id', '=', $id)
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
        $label = DB::table('labels as l')
            ->where('l.id', '=', $id)
            ->get()->toJson(JSON_PRETTY_PRINT);
        return response($label, 200);
    }

    protected function getAllShared()
    {
        $shared = DB::table('shared_hosting as sh')
            ->Join('pricings as p', 'sh.id', '=', 'p.service_id')
            ->get(['sh.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($shared, 200);
    }

    protected function getShared($id)
    {
        $shared = DB::table('shared_hosting as sh')
            ->Join('pricings as p', 'sh.id', '=', 'p.service_id')
            ->where('sh.id', '=', $id)
            ->get(['sh.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($shared, 200);
    }

    protected function getAllReseller()
    {
        $reseller = DB::table('reseller_hosting as rh')
            ->Join('pricings as p', 'rh.id', '=', 'p.service_id')
            ->get(['rh.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getReseller($id)
    {
        $reseller = DB::table('reseller_hosting as rh')
            ->Join('pricings as p', 'rh.id', '=', 'p.service_id')
            ->where('rh.id', '=', $id)
            ->get(['rh.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getAllSeedbox()
    {
        $reseller = DB::table('seedboxes as sb')
            ->Join('pricings as p', 'sb.id', '=', 'p.service_id')
            ->get(['sb.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getSeedbox($id)
    {
        $reseller = DB::table('seedboxes as sb')
            ->Join('pricings as p', 'sb.id', '=', 'p.service_id')
            ->where('sb.id', '=', $id)
            ->get(['sb.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($reseller, 200);
    }

    protected function getAllDomains()
    {
        $domains = DB::table('domains as d')
            ->Join('pricings as p', 'd.id', '=', 'p.service_id')
            ->get(['d.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($domains, 200);
    }

    protected function getDomains($id)
    {
        $domain = DB::table('domains as d')
            ->Join('pricings as p', 'd.id', '=', 'p.service_id')
            ->where('d.id', '=', $id)
            ->get(['d.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($domain, 200);
    }

    protected function getAllMisc()
    {
        $misc = DB::table('misc_services as m')
            ->Join('pricings as p', 'm.id', '=', 'p.service_id')
            ->get(['m.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
        return response($misc, 200);
    }

    protected function getMisc($id)
    {
        $misc = DB::table('misc_services as m')
            ->Join('pricings as p', 'm.id', '=', 'p.service_id')
            ->where('m.id', '=', $id)
            ->get(['m.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date'])->toJson(JSON_PRETTY_PRINT);
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

    public function updateServer(Request $request, Server $server)
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

}
