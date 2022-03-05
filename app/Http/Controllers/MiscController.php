<?php

namespace App\Http\Controllers;

use App\Models\Misc;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MiscController extends Controller
{
    public function index()
    {
        $misc = DB::table('misc_services as d')
            ->join('pricings as pr', 'd.id', '=', 'pr.service_id')
            ->get(['d.*', 'pr.*']);

        return view('misc.index', compact(['misc']));
    }

    public function create()
    {
        return view('misc.create');
    }

    public function show(Misc $misc)
    {
        $service_extras = DB::table('misc_services as m')
            ->join('pricings as p', 'm.id', '=', 'p.service_id')
            ->where('m.id', '=', $misc->id)
            ->get(['m.*', 'p.*']);

        return view('misc.show', compact(['misc', 'service_extras']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'owned_since' => 'date',
            'next_due_date' => 'required|date'
        ]);

        $ms_id = Str::random(8);

        Misc::create([
            'id' => $ms_id,
            'name' => $request->name,
            'owned_since' => $request->owned_since
        ]);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        Pricing::create([
            'service_id' => $ms_id,
            'service_type' => 5,
            'currency' => $request->currency,
            'price' => $request->price,
            'term' => $request->payment_term,
            'as_usd' => $as_usd,
            'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
            'next_due_date' => $request->next_due_date,
        ]);

        return redirect()->route('misc.index')
            ->with('success', 'Misc service created Successfully.');
    }

    public function edit(Misc $misc)
    {
        $misc = DB::table('misc_services as s')
            ->join('pricings as p', 's.id', '=', 'p.service_id')
            ->where('s.id', '=', $misc->id)
            ->get(['s.*', 'p.*']);

        return view('misc.edit', compact('misc'));
    }

    public function update(Request $request, Misc $misc)
    {
        $request->validate([
            'name' => 'required',
            'owned_since' => 'date',
        ]);

        DB::table('misc_services')
            ->where('id', $misc->id)
            ->update([
                'name' => $request->name,
                'owned_since' => $request->owned_since,
                'active' => (isset($request->is_active)) ? 1 : 0
            ]);

        $pricing = new Pricing();

        $as_usd = $pricing->convertToUSD($request->price, $request->currency);

        DB::table('pricings')
            ->where('service_id', $misc->id)
            ->update([
                'currency' => $request->currency,
                'price' => $request->price,
                'term' => $request->payment_term,
                'as_usd' => $as_usd,
                'usd_per_month' => $pricing->costAsPerMonth($as_usd, $request->payment_term),
                'next_due_date' => $request->next_due_date,
                'active' => (isset($request->is_active)) ? 1 : 0
            ]);

        return redirect()->route('misc.index')
            ->with('success', 'Misc service updated Successfully.');
    }

    public function destroy(Misc $misc)
    {
        $items = Misc::find($misc->id);

        $items->delete();

        $p = new Pricing();
        $p->deletePricing($misc->id);

        return redirect()->route('misc.index')
            ->with('success', 'Misc service was deleted Successfully.');
    }
}
