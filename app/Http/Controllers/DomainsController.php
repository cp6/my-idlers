<?php

namespace App\Http\Controllers;

use App\Models\Domains;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomainsController extends Controller
{

    public function index()
    {
        $domains = DB::table('domains as d')
            ->join('providers as p', 'd.provider_id', '=', 'p.id')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->get(['d.*', 'p.name as provider_name', 'pr.*']);

        return view('domains.index', compact(['domains']));
    }

    public function show(Domains $domain)
    {

        $service_extras = DB::table('domains as d')
            ->join('providers as p', 'd.provider_id', '=', 'p.id')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->where('d.id', '=', $domain->id)
            ->get(['d.*', 'p.name as provider_name', 'pr.*']);

        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $domain->id)
            ->get(['labels.label']);

        return view('domains.show', compact(['domain', 'service_extras', 'labels']));
    }

    public function create()
    {
        $Providers = Providers::all();
        return view('domains.create', compact('Providers'));
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

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        Pricing::create([
            'service_id' => $domain_id,
            'service_type' => 4,
            'currency' => $request->currency,
            'price' => $request->price,
            'term' => $request->payment_term,
            'as_usd' => $as_usd,
            'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
            'next_due_date' => $request->next_due_date,
        ]);

        $labels_array = [$request->label1, $request->label2, $request->label3, $request->label4];

        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::insert('INSERT INTO labels_assigned (label_id, service_id) values (?, ?)', [$labels_array[($i - 1)], $domain_id]);
            }
        }

        return redirect()->route('domains.index')
            ->with('success', 'Domain Created Successfully.');
    }

    public function edit(Domains $domain)
    {
        $domain_info = DB::table('domains as d')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->where('d.id', '=', $domain->id)
            ->get(['d.*', 'pr.*']);

        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $domain->id)
            ->get(['labels.id', 'labels.label']);

        return view('domains.edit', compact(['domain', 'domain_info', 'labels']));
    }

    public function update(Request $request, Domains $domain)
    {
        $request->validate([
            'domain' => 'required|min:2',
            'extension' => 'required|min:2',
            'provider_id' => 'numeric',
            'price' => 'numeric'
        ]);

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

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        DB::table('pricings')
            ->where('service_id', $domain->id)
            ->update([
                'service_type' => 4,
                'currency' => $request->currency,
                'price' => $request->price,
                'term' => $request->payment_term,
                'as_usd' => $as_usd,
                'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
                'next_due_date' => $request->next_due_date,
                'active' => (isset($request->is_active)) ? 1 : 0
            ]);

        $deleted = DB::table('labels_assigned')->where('service_id', '=', $domain->id)->delete();

        $labels_array = [$request->label1, $request->label2, $request->label3, $request->label4];

        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::insert('INSERT IGNORE INTO labels_assigned ( label_id, service_id) values (?, ?)', [$labels_array[($i - 1)], $domain->id]);
            }
        }

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

        return redirect()->route('domains.index')
            ->with('success', 'Domain was deleted Successfully.');
    }

}
