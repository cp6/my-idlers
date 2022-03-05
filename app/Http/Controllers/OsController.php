<?php

namespace App\Http\Controllers;

use App\Models\OS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            'os_name' => 'required|min:2'
        ]);

        OS::create([
            'name' => $request->os_name
        ]);

        Cache::forget('all_os');

        return redirect()->route('os.index')
            ->with('success', 'OS Created Successfully.');
    }

    public function destroy(OS $o)
    {
        $items = OS::find($o->id);

        $items->delete();

        Cache::forget('all_os');

        return redirect()->route('os.index')
            ->with('success', 'OS was deleted Successfully.');
    }
}
