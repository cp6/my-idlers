<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\IPs;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SharedController extends Controller
{
    public function index()
    {
        $shared = Shared::allSharedHosting();
        return view('shared.index', compact(['shared']));
    }

    public function create()
    {
        return view('shared.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|min:4',
            'shared_type' => 'required|string',
            'disk' => 'integer',
            'os_id' => 'integer',
            'provider_id' => 'integer',
            'location_id' => 'integer',
            'price' => 'numeric',
            'payment_term' => 'integer',
            'was_promo' => 'integer',
            'owned_since' => 'sometimes|nullable|date',
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

        $shared_id = Str::random(8);

        $pricing = new Pricing();
        $pricing->insertPricing(2, $shared_id, $request->currency, $request->price, $request->payment_term, $request->next_due_date);

        Labels::deleteLabelsAssignedTo($shared_id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $shared_id);

        IPs::deleteIPsAssignedTo($shared_id);
        if (!is_null($request->dedicated_ip)) {
            IPs::insertIP($shared_id, $request->dedicated_ip);
        }

        Shared::create([
            'id' => $shared_id,
            'main_domain' => $request->domain,
            'shared_type' => $request->shared_type,
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
            'db__limit' => $request->db
        ]);

        Cache::forget('all_shared');
        Home::homePageCacheForget();

        return redirect()->route('shared.index')
            ->with('success', 'Shared hosting created Successfully.');
    }

    public function show(Shared $shared)
    {
        $shared = Shared::sharedHosting($shared->id);
        return view('shared.show', compact(['shared']));
    }

    public function edit(Shared $shared)
    {
        $shared = Shared::sharedHosting($shared->id);
        return view('shared.edit', compact(['shared']));
    }

    public function update(Request $request, Shared $shared)
    {
        $request->validate([
            'domain' => 'required|min:4',
            'shared_type' => 'required|string',
            'disk' => 'integer',
            'os_id' => 'integer',
            'provider_id' => 'integer',
            'location_id' => 'integer',
            'price' => 'numeric',
            'payment_term' => 'integer',
            'was_promo' => 'integer',
            'owned_since' => 'sometimes|nullable|date',
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

        $shared->update([
            'main_domain' => $request->domain,
            'shared_type' => $request->shared_type,
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
        Cache::forget("labels_for_service.{$request->id}");

        IPs::deleteIPsAssignedTo($request->id);
        if (isset($request->dedicated_ip)) {
            IPs::insertIP($request->id, $request->dedicated_ip);
        }

        Cache::forget("shared_hosting.{$request->id}");
        Cache::forget('all_shared');
        Home::homePageCacheForget();

        return redirect()->route('shared.index')
            ->with('success', 'Shared hosting updated Successfully.');
    }

    public function destroy(Shared $shared)
    {
        $shared_id = $shared->id;
        $items = Shared::find($shared_id);
        $items->delete();

        $p = new Pricing();
        $p->deletePricing($shared_id);

        Labels::deleteLabelsAssignedTo($shared_id);

        IPs::deleteIPsAssignedTo($shared_id);

        Cache::forget("shared_hosting.$shared_id");
        Cache::forget('all_shared');
        Home::homePageCacheForget();

        return redirect()->route('shared.index')
            ->with('success', 'Shared hosting was deleted Successfully.');
    }

}
