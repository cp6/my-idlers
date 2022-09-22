<?php

namespace App\Http\Controllers;

use App\Models\Domains;
use App\Models\Home;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomainsController extends Controller
{
    public function index()
    {
        $domains = Domains::allDomains();
        return view('domains.index', compact(['domains']));
    }

    public function show(Domains $domain)
    {//Need to modern
        $domain_info = Domains::domain($domain->id);
        return view('domains.show', compact(['domain_info']));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|min:2',
            'extension' => 'required|min:2',
            'provider_id' => 'numeric',
            'price' => 'numeric',
            'next_due_date' => 'required|date'
        ]);

        $domain_id = Str::random(8);
        $pricing = new Pricing();
        $pricing->insertPricing(4, $domain_id, $request->currency, $request->price, $request->payment_term, $request->next_due_date);

        Domains::create([
            'id' => $domain_id,
            'domain' => $request->domain,
            'extension' => $request->extension,
            'ns1' => $request->ns1,
            'ns2' => $request->ns2,
            'ns3' => $request->ns3,
            'provider_id' => $request->provider_id,
            'owned_since' => $request->owned_since
        ]);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $domain_id);

        Cache::forget("all_domains");
        Home::homePageCacheForget();

        return redirect()->route('domains.index')
            ->with('success', 'Domain Created Successfully.');
    }

    public function edit(Domains $domain)
    {
        $domain_info = Domains::domain($domain->id);
        return view('domains.edit', compact(['domain_info']));
    }

    public function update(Request $request, Domains $domain)
    {
        $request->validate([
            'domain' => 'required|min:2',
            'extension' => 'required|min:2',
            'provider_id' => 'numeric',
            'price' => 'numeric'
        ]);

        $pricing = new Pricing();
        $as_usd = $pricing->convertToUSD($request->price, $request->currency);
        $pricing->updatePricing($domain->id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        $domain->update([
            'domain' => $request->domain,
            'extension' => $request->extension,
            'ns1' => $request->ns1,
            'ns2' => $request->ns2,
            'ns3' => $request->ns3,
            'provider_id' => $request->provider_id,
            'owned_since' => $request->owned_since,
            'active' => (isset($request->is_active)) ? 1 : 0
        ]);

        Labels::deleteLabelsAssignedTo($domain->id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $domain->id);

        Cache::forget("all_domains");
        Cache::forget("domain.{$domain->id}");
        Cache::forget("labels_for_service.{$domain->id}");
        Home::homePageCacheForget();

        return redirect()->route('domains.index')
            ->with('success', 'Domain Updated Successfully.');
    }

    public function destroy(Domains $domain)
    {
        $items = Domains::find($domain->id);
        $items->delete();

        $p = new Pricing();
        $p->deletePricing($domain->id);

        Labels::deleteLabelsAssignedTo($domain->id);

        Cache::forget("all_domains");
        Cache::forget("domain.{$domain->id}");
        Home::homePageCacheForget();

        return redirect()->route('domains.index')
            ->with('success', 'Domain was deleted Successfully.');
    }

}
