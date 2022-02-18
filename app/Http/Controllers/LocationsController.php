<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;


class LocationsController extends Controller
{
    public function index()
    {
        $locations = Locations::all();
        return view('locations.index', compact(['locations']));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|min:2'
        ]);

        Locations::create([
            'name' => $request->location_name
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Location Created Successfully.');
    }

    public function destroy(Locations $location)
    {
        $items = Locations::find($location->id);

        $items->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Location was deleted Successfully.');
    }
}
