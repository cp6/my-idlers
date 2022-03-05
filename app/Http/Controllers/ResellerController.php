<?php

namespace App\Http\Controllers;

use App\Models\IPs;
use App\Models\Labels;
use App\Models\Locations;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = DB::table('reseller_hosting as s')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->get(['s.*', 'p.name as provider_name', 'pr.*', 'l.name as location']);

        return view('reseller.index', compact(['resellers']));
    }

    public function create()
    {
        $Providers = Providers::all();
        $Locations = Locations::all();
        return view('reseller.create', compact(['Providers', 'Locations']));
    }

    public function store(Request $request)
    {

        $request->validate([
            'domain' => 'required|min:4',
            'reseller_type' => 'required',
            'dedicated_ip' => 'present',
            'accounts' => 'numeric',
            'server_type' => 'numeric',
            'ram' => 'numeric',
            'disk' => 'numeric',
            'os_id' => 'numeric',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'payment_term' => 'numeric',
            'was_promo' => 'numeric',
            'owned_since' => 'date',
            'domains' => 'numeric',
            'sub_domains' => 'numeric',
            'bandwidth' => 'numeric',
            'email' => 'numeric',
            'ftp' => 'numeric',
            'db' => 'numeric',
            'next_due_date' => 'required|date'
        ]);

        $reseller_id = Str::random(8);

        Reseller::create([
            'id' => $reseller_id,
            'main_domain' => $request->domain,
            'accounts' => $request->accounts,
            'reseller_type' => $request->reseller_type,
            'provider_id' => $request->provider_id,
            'location_id' => $request->location_id,
            'disk' => $request->disk,
            'disk_type' => 'GB',
            'disk_as_gb' => $request->disk,
            'owned_since' => $request->owned_since,
            'bandwidth' => $request->bandwidth,
            'was_promo' => $request->was_promo,
            'domains_limit' => $request->domains,
            'subdomains_limit' => $request->sub_domains,
            'email_limit' => $request->email,
            'ftp_limit' => $request->ftp,
            'db_limit' => $request->db
        ]);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        Pricing::create([
            'service_id' => $reseller_id,
            'service_type' => 3,
            'currency' => $request->currency,
            'price' => $request->price,
            'term' => $request->payment_term,
            'as_usd' => $as_usd,
            'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
            'next_due_date' => $request->next_due_date,
        ]);

        if (!is_null($request->dedicated_ip)) {
            IPs::create(
                [
                    'id' => Str::random(8),
                    'service_id' => $reseller_id,
                    'address' => $request->dedicated_ip,
                    'is_ipv4' => (filter_var($request->dedicated_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? 0 : 1,
                    'active' => 1
                ]
            );
        }

        $labels_array = [$request->label1, $request->label2, $request->label3, $request->label4];

        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::insert('INSERT IGNORE INTO labels_assigned (label_id, service_id) values (?, ?)', [$labels_array[($i - 1)], $reseller_id]);
            }
        }

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting created Successfully.');
    }


    public function show(Reseller $reseller)
    {
        $reseller_extras = DB::table('reseller_hosting as s')
            ->join('pricings as pr', 's.id', '=', 'pr.service_id')
            ->join('providers as p', 's.provider_id', '=', 'p.id')
            ->join('locations as l', 's.location_id', '=', 'l.id')
            ->where('s.id', '=', $reseller->id)
            ->get(['s.*', 'p.name as provider_name', 'l.name as location', 'pr.*']);

        $labels = DB::table('labels_assigned as l')
            ->LeftJoin('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $reseller->id)
            ->get(['labels.label']);

        $ip_address = DB::table('ips as i')
            ->where('i.service_id', '=', $reseller->id)
            ->get();

        return view('reseller.show', compact(['reseller', 'reseller_extras', 'labels', 'ip_address']));
    }

    public function edit(Reseller $reseller)
    {
        $locations = DB::table('locations')->get(['*']);
        $providers = json_decode(DB::table('providers')->get(['*']), true);

        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $reseller->id)
            ->get(['labels.id', 'labels.label']);

        $ip_address = json_decode(DB::table('ips as i')
            ->where('i.service_id', '=', $reseller->id)
            ->get(), true);

        $reseller = DB::table('reseller_hosting as s')
            ->join('pricings as p', 's.id', '=', 'p.service_id')
            ->where('s.id', '=', $reseller->id)
            ->get(['s.*', 'p.*']);

        return view('reseller.edit', compact(['reseller', 'locations', 'providers', 'ip_address', 'labels']));
    }

    public function update(Request $request, Reseller $reseller)
    {
        $request->validate([
            'id' => 'required|size:8',
            'domain' => 'required|min:4',
            'reseller_type' => 'required',
            'dedicated_ip' => 'present',
            'server_type' => 'numeric',
            'disk' => 'numeric',
            'os_id' => 'numeric',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'payment_term' => 'numeric',
            'was_promo' => 'numeric',
            'owned_since' => 'date',
            'domains' => 'numeric',
            'sub_domains' => 'numeric',
            'bandwidth' => 'numeric',
            'email' => 'numeric',
            'ftp' => 'numeric',
            'db' => 'numeric'
        ]);

        DB::table('reseller_hosting')
            ->where('id', $request->id)
            ->update([
                'main_domain' => $request->domain,
                'reseller_type' => $request->reseller_type,
                'provider_id' => $request->provider_id,
                'location_id' => $request->location_id,
                'disk' => $request->disk,
                'disk_type' => 'GB',
                'disk_as_gb' => $request->disk,
                'owned_since' => $request->owned_since,
                'bandwidth' => $request->bandwidth,
                'was_promo' => $request->was_promo,
                'domains_limit' => $request->domains,
                'subdomains_limit' => $request->sub_domains,
                'email_limit' => $request->email,
                'ftp_limit' => $request->ftp,
                'db_limit' => $request->db
            ]);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        DB::table('pricings')
            ->where('service_id', $request->id)
            ->update([
                'currency' => $request->currency,
                'price' => $request->price,
                'term' => $request->payment_term,
                'as_usd' => $as_usd,
                'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
                'next_due_date' => $request->next_due_date,
            ]);

        $deleted = DB::table('labels_assigned')->where('service_id', '=', $request->id)->delete();

        $labels_array = [$request->label1, $request->label2, $request->label3, $request->label4];

        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::insert('INSERT IGNORE INTO labels_assigned ( label_id, service_id) values (?, ?)', [$labels_array[($i - 1)], $request->id]);
            }
        }

        $delete_ip = DB::table('ips')->where('service_id', '=', $request->id)->delete();

        if (isset($request->dedicated_ip)) {
            DB::insert('INSERT IGNORE INTO ips (id, address, service_id, is_ipv4) values (?, ?, ?, ?)', [
                Str::random(8),
                $request->dedicated_ip,
                $request->id,
                (filter_var($request->dedicated_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? 0 : 1
            ]);
        }

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting updated Successfully.');
    }

    public function destroy(Reseller $reseller)
    {
        $id = $reseller->id;
        $items = Reseller::find($id);

        $items->delete();

        $p = new Pricing();
        $p->deletePricing($id);

        Labels::deleteLabelsAssignedTo($id);

        IPs::deleteIPsAssignedTo($id);

        Cache::forget('services_count');//Main page services_count cache
        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting was deleted Successfully.');
    }
}
