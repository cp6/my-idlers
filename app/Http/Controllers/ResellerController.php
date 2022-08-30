<?php

namespace App\Http\Controllers;

use App\Models\Home;
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
        $resellers = Reseller::allResellerHosting();
        return view('reseller.index', compact(['resellers']));
    }

    public function create()
    {
        return view('reseller.create');
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

        $pricing = new Pricing();
        $pricing->insertPricing(3, $reseller_id, $request->currency, $request->price, $request->payment_term, $request->next_due_date);

        if (!is_null($request->dedicated_ip)) {
            IPs::insertIP($reseller_id, $request->dedicated_ip);
        }

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $reseller_id);

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

        Cache::forget("all_reseller");
        Home::homePageCacheForget();

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting created Successfully.');
    }

    public function show(Reseller $reseller)
    {
        $reseller = Reseller::resellerHosting($reseller->id)[0];
        return view('reseller.show', compact(['reseller']));
    }

    public function edit(Reseller $reseller)
    {
        $reseller = Reseller::resellerHosting($reseller->id)[0];
        return view('reseller.edit', compact(['reseller']));
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
        $pricing->updatePricing($request->id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        Labels::deleteLabelsAssignedTo($request->id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $request->id);

        IPs::deleteIPsAssignedTo($request->id);

        if (isset($request->dedicated_ip)) {
            IPs::insertIP($request->id, $request->dedicated_ip);
        }

        Cache::forget("reseller_hosting.{$request->id}");
        Cache::forget("labels_for_service.{$request->id}");

        Home::homePageCacheForget();

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting updated Successfully.');
    }

    public function destroy(Reseller $reseller)
    {
        $reseller_id = $reseller->id;
        $items = Reseller::find($reseller_id);
        $items->delete();

        $p = new Pricing();
        $p->deletePricing($reseller_id);

        Labels::deleteLabelsAssignedTo($reseller_id);

        IPs::deleteIPsAssignedTo($reseller_id);

        Cache::forget("all_reseller");
        Cache::forget("reseller_hosting.$reseller_id");
        Home::homePageCacheForget();

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting was deleted Successfully.');
    }
}
