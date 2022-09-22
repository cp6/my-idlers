<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\IPs;
use App\Models\Labels;
use App\Models\Pricing;
use App\Models\SeedBoxes;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedBoxesController extends Controller
{
    public function index()
    {
        $seedboxes = SeedBoxes::allSeedboxes();
        return view('seedboxes.index', compact(['seedboxes']));
    }

    public function create()
    {
        return view('seedboxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'hostname' => 'string|nullable',
            'seed_box_type' => 'required',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'payment_term' => 'numeric',
            'was_promo' => 'numeric',
            'owned_since' => 'date',
            'disk' => 'numeric',
            'bandwidth' => 'numeric',
            'port_speed' => 'numeric',
            'next_due_date' => 'required|date'
        ]);

        $seedbox_id = Str::random(8);

        $pricing = new Pricing();
        $pricing->insertPricing(6, $seedbox_id, $request->currency, $request->price, $request->payment_term, $request->next_due_date);

        Labels::deleteLabelsAssignedTo($seedbox_id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $seedbox_id);

        SeedBoxes::create([
            'id' => $seedbox_id,
            'title' => $request->title,
            'hostname' => $request->hostname,
            'seed_box_type' => $request->seed_box_type,
            'provider_id' => $request->provider_id,
            'location_id' => $request->location_id,
            'disk' => $request->disk,
            'disk_type' => 'GB',
            'disk_as_gb' => $request->disk,
            'owned_since' => $request->owned_since,
            'bandwidth' => $request->bandwidth,
            'port_speed' => $request->port_speed,
            'was_promo' => $request->was_promo
        ]);

        Cache::forget("all_seedboxes");
        Home::homePageCacheForget();

        return redirect()->route('seedboxes.index')
            ->with('success', 'Seed box created Successfully.');

    }

    public function show(SeedBoxes $seedbox)
    {
        $seedbox_data = SeedBoxes::seedbox($seedbox->id);
        return view('seedboxes.show', compact(['seedbox_data']));
    }

    public function edit(SeedBoxes $seedbox)
    {
        $seedbox_data = SeedBoxes::seedbox($seedbox->id);
        return view('seedboxes.edit', compact(['seedbox_data']));
    }

    public function update(Request $request, SeedBoxes $seedbox)
    {
        $request->validate([
            'id' => 'required|size:8',
            'title' => 'required|string',
            'hostname' => 'string|nullable',
            'seed_box_type' => 'required',
            'disk' => 'numeric',
            'provider_id' => 'numeric',
            'location_id' => 'numeric',
            'price' => 'numeric',
            'payment_term' => 'numeric',
            'was_promo' => 'numeric',
            'owned_since' => 'date',
            'bandwidth' => 'numeric',
            'port_speed' => 'numeric'
        ]);

        DB::table('seedboxes')
            ->where('id', $seedbox->id)
            ->update([
                'title' => $request->title,
                'hostname' => $request->hostname,
                'seed_box_type' => $request->seed_box_type,
                'location_id' => $request->location_id,
                'provider_id' => $request->provider_id,
                'disk' => $request->disk,
                'disk_type' => 'GB',
                'disk_as_gb' => $request->disk,
                'owned_since' => $request->owned_since,
                'bandwidth' => $request->bandwidth,
                'port_speed' => $request->port_speed,
                'was_promo' => $request->was_promo
            ]);

        $pricing = new Pricing();
        $as_usd = $pricing->convertToUSD($request->price, $request->currency);
        $pricing->updatePricing($seedbox->id, $request->currency, $request->price, $request->payment_term, $as_usd, $request->next_due_date);

        Labels::deleteLabelsAssignedTo($seedbox->id);
        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $seedbox->id);

        Cache::forget("all_seedboxes");
        Cache::forget("seedbox.{$seedbox->id}");
        Cache::forget("labels_for_service.{$seedbox->id}");
        Home::homePageCacheForget();

        return redirect()->route('seedboxes.index')
            ->with('success', 'Seed box updated Successfully.');
    }

    public function destroy(SeedBoxes $seedbox)
    {
        $seedbox_id = $seedbox->id;
        $items = SeedBoxes::find($seedbox_id);
        $items->delete();

        $p = new Pricing();
        $p->deletePricing($seedbox_id);

        Labels::deleteLabelsAssignedTo($seedbox_id);

        Cache::forget("all_seedboxes");
        Cache::forget("seedbox.{$seedbox->id}");
        Home::homePageCacheForget();

        return redirect()->route('seedboxes.index')
            ->with('success', 'Seed box was deleted Successfully.');
    }
}
