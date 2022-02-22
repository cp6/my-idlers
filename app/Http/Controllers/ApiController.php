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

class ApiController extends Controller
{
    protected function getAllServers()
    {
        $servers = DB::table('servers as s')
            ->Join('pricings as p', 's.id', '=', 'p.service_id')
            ->join('providers as pr', 's.provider_id', '=', 'pr.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('os as o', 's.os_id', '=', 'o.id')
            ->get(['s.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date', 'pr.name as provider', 'l.name as location','o.name as os'])->toJson(JSON_PRETTY_PRINT);

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
            ->get(['s.*', 'p.id as price_id', 'p.currency', 'p.price', 'p.term', 'p.as_usd', 'p.usd_per_month', 'p.next_due_date', 'pr.name as provider', 'l.name as location','o.name as os']);

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
        $os = OS::all()->toJson(JSON_PRETTY_PRINT);
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

}
