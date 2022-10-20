<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class LocationsController extends Controller
{
    public function index()
    {
        $locations = Locations::allLocations();
        return view('locations.index', compact(['locations']));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|min:2'
        ]);

        Locations::create([
            'name' => $request->location_name
        ]);

        Cache::forget('locations');

        return redirect()->route('locations.index')
            ->with('success', 'Location Created Successfully.');
    }

    public function show(Locations $location)
    {
        $servers = DB::table('servers as s')
            ->where('s.location_id', '=', $location->id)
            ->get(['s.id', 's.hostname'])
            ->toArray();

        $shared = DB::table('shared_hosting as s')
            ->where('s.location_id', '=', $location->id)
            ->get(['s.id', 's.main_domain as main_domain_shared'])
            ->toArray();

        $reseller = DB::table('reseller_hosting as r')
            ->where('r.location_id', '=', $location->id)
            ->get(['r.id', 'r.main_domain as main_domain_reseller'])
            ->toArray();

        $data = array_merge($servers, $shared, $reseller);

        return view('locations.show', compact(['location', 'data']));
    }

    public function destroy(Locations $location)
    {
        $items = Locations::find($location->id);

        $items->delete();

        Cache::forget('locations');

        return redirect()->route('locations.index')
            ->with('success', 'Location was deleted Successfully.');
    }
}
