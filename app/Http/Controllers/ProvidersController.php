<?php

namespace App\Http\Controllers;

use App\Models\Providers;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProvidersController extends Controller
{
    public function index()
    {
        $providers = Providers::allProviders();
        return view('providers.index', compact(['providers']));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_name' => 'required|string|min:2'
        ]);

        Providers::create([
            'name' => $request->provider_name
        ]);

        Cache::forget('providers');

        return redirect()->route('providers.index')
            ->with('success', 'Provider Created Successfully.');
    }

    public function show(Providers $provider)
    {
        $data = Providers::showServicesForProvider($provider->id);

        return view('providers.show', compact(['provider', 'data']));
    }

    public function destroy(Providers $provider)
    {
        $items = Providers::find($provider->id);

        $items->delete();

        Cache::forget('providers');

        return redirect()->route('providers.index')
            ->with('success', 'Provider was deleted Successfully.');
    }

}
