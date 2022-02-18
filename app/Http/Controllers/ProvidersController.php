<?php

namespace App\Http\Controllers;

use App\Models\Providers;
use DataTables;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function index()
    {
        $providers = Providers::all();
        return view('providers.index', compact(['providers']));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_name' => 'required|min:2'
        ]);

        Providers::create([
            'name' => $request->provider_name
        ]);

        return redirect()->route('providers.index')
            ->with('success', 'Provider Created Successfully.');
    }

    public function destroy(Providers $provider)
    {
        $items = Providers::find($provider->id);

        $items->delete();

        return redirect()->route('providers.index')
            ->with('success', 'Provider was deleted Successfully.');
    }

    public function getProviders(Request $request)
    {
        if ($request->ajax()) {
            $data = Providers::latest()->get();
            $dt = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

}
