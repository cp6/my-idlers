<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Misc;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MiscController extends Controller
{
    public function index()
    {
        $misc = Misc::allMisc();
        return view('misc.index', compact(['misc']));
    }

    public function create()
    {
        return view('misc.create');
    }

    public function show(Misc $misc)
    {
        $misc_data = Misc::misc($misc->id)[0];
        return view('misc.show', compact(['misc_data']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'owned_since' => 'date',
            'next_due_date' => 'required|date'
        ]);

        $misc_id = Str::random(8);

        $pricing = new Pricing();
        $as_usd = $pricing->convertToUSD($request->price, $request->currency);
        $pricing->insertPricing(5, $misc_id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        Misc::create([
            'id' => $misc_id,
            'name' => $request->name,
            'owned_since' => $request->owned_since
        ]);

        Cache::forget("all_misc");
        Home::homePageCacheForget();

        return redirect()->route('misc.index')
            ->with('success', 'Misc service created Successfully.');
    }

    public function edit(Misc $misc)
    {
        $misc_data = Misc::misc($misc->id)[0];
        return view('misc.edit', compact('misc_data'));
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
        $pricing->updatePricing($misc->id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        Cache::forget("all_misc");
        Cache::forget("misc.{$misc->id}");
        Home::homePageCacheForget();

        return redirect()->route('misc.index')
            ->with('success', 'Misc service updated Successfully.');
    }

    public function destroy(Misc $misc)
    {
        $items = Misc::find($misc->id);
        $items->delete();

        $p = new Pricing();
        $p->deletePricing($misc->id);

        Cache::forget("all_misc");
        Cache::forget("misc.{$misc->id}");
        Home::homePageCacheForget();

        return redirect()->route('misc.index')
            ->with('success', 'Misc service was deleted Successfully.');
    }
}
