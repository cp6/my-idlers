<?php

namespace App\Http\Controllers;

use App\Models\OS;
use Illuminate\Http\Request;

class OsController extends Controller
{
    public function index()
    {
        $os = OS::all();
        return view('os.index', compact(['os']));
    }

    public function create()
    {
        return view('os.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);

        OS::create([
            'name' => $request->os_name
        ]);

        return redirect()->route('os.index')
            ->with('success', 'OS Created Successfully.');
    }

    public function destroy(OS $OS)
    {
        $items = OS::find($OS->id);

        $items->delete();

        return redirect()->route('os.index')
            ->with('success', 'OS was deleted Successfully.');
    }
}
