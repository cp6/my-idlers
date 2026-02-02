<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\IPs;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            'reseller_type' => 'required|string',
            'disk' => 'integer',
            'os_id' => 'integer',
            'provider_id' => 'integer',
            'location_id' => 'integer',
            'price' => 'numeric',
            'payment_term' => 'integer',
            'was_promo' => 'integer',
            'owned_since' => 'sometimes|nullable|date',
            'accounts' => 'integer',
            'domains' => 'integer',
            'sub_domains' => 'integer',
            'bandwidth' => 'integer',
            'email' => 'integer',
            'ftp' => 'integer',
            'db' => 'integer',
            'next_due_date' => 'required|date',
            'label1' => 'sometimes|nullable|string',
            'label2' => 'sometimes|nullable|string',
            'label3' => 'sometimes|nullable|string',
            'label4' => 'sometimes|nullable|string',
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
        $reseller = Reseller::resellerHosting($reseller->id);
        return view('reseller.show', compact(['reseller']));
    }

    public function edit(Reseller $reseller)
    {
        $reseller = Reseller::resellerHosting($reseller->id);
        return view('reseller.edit', compact(['reseller']));
    }

    public function update(Request $request, Reseller $reseller)
    {
        $request->validate([
            'domain' => 'required|min:4',
            'reseller_type' => 'required|string',
            'disk' => 'integer',
            'os_id' => 'integer',
            'provider_id' => 'integer',
            'location_id' => 'integer',
            'price' => 'numeric',
            'payment_term' => 'integer',
            'was_promo' => 'integer',
            'owned_since' => 'sometimes|nullable|date',
            'accounts' => 'integer',
            'domains' => 'integer',
            'sub_domains' => 'integer',
            'bandwidth' => 'integer',
            'email' => 'integer',
            'ftp' => 'integer',
            'db' => 'integer',
            'next_due_date' => 'required|date',
            'label1' => 'sometimes|nullable|string',
            'label2' => 'sometimes|nullable|string',
            'label3' => 'sometimes|nullable|string',
            'label4' => 'sometimes|nullable|string',
        ]);

        $is_active = (isset($request->is_active)) ? 1 : 0;

        $reseller->update([
            'main_domain' => $request->domain,
            'reseller_type' => $request->reseller_type,
            'provider_id' => $request->provider_id,
            'location_id' => $request->location_id,
            'accounts' => $request->accounts,
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
            'db_limit' => $request->db,
            'active' => $is_active
        ]);

        $pricing = new Pricing();
        $pricing->updatePricing($reseller->id, $request->currency, $request->price, $request->payment_term, $request->next_due_date, $is_active);

        Labels::deleteLabelsAssignedTo($reseller->id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $reseller->id);

        IPs::deleteIPsAssignedTo($reseller->id);

        if (!is_null($request->dedicated_ip)) {
            IPs::insertIP($reseller->id, $request->dedicated_ip);
        }

        Cache::forget("all_reseller");
        Cache::forget("reseller_hosting.{$reseller->id}");
        Cache::forget("labels_for_service.{$reseller->id}");

        Home::homePageCacheForget();

        return redirect()->route('reseller.index')
            ->with('success', 'Reseller hosting updated Successfully.');
    }

    public function destroy(Reseller $reseller)
    {
        if ($reseller->delete()) {
            $p = new Pricing();
            $p->deletePricing($reseller->id);

            Labels::deleteLabelsAssignedTo($reseller->id);

            IPs::deleteIPsAssignedTo($reseller->id);

            Cache::forget("all_reseller");
            Cache::forget("reseller_hosting.$reseller->id");
            Home::homePageCacheForget();

            return redirect()->route('reseller.index')
                ->with('success', 'Reseller hosting was deleted Successfully.');
        }

        return redirect()->route('reseller.index')
            ->with('error', 'Reseller was not deleted.');

    }
}
