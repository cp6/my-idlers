<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LabelsController extends Controller
{

    public function index()
    {
        $labels = Labels::all();
        return view('labels.index', compact(['labels']));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|min:2'
        ]);

        Labels::create([
            'id' => Str::random(8),
            'label' => $request->label
        ]);

        Cache::forget('all_labels');
        Cache::forget('labels_count');

        return redirect()->route('labels.index')
            ->with('success', 'Label Created Successfully.');
    }

    public function show(Labels $label)
    {
        $labels = DB::table('labels_assigned as las')
            ->leftJoin('pricings as p', 'las.service_id', '=', 'p.service_id')
            ->leftJoin('servers as s', 'las.service_id', '=', 's.id')
            ->leftJoin('shared_hosting as sh', 'las.service_id', '=', 'sh.id')
            ->leftJoin('reseller_hosting as r', 'las.service_id', '=', 'r.id')
            ->leftJoin('domains as d', 'las.service_id', '=', 'd.id')
            ->where('las.label_id', '=', $label->id)
            ->get(['p.service_type', 'p.service_id', 's.hostname', 'sh.main_domain as shared', 'r.main_domain as reseller', 'd.domain', 'd.extension']);

        return view('labels.show', compact(['label', 'labels']));
    }

    public function edit(Labels $label)
    {
        abort(404);
    }

    public function destroy(Labels $label)
    {
        $label_id = $label->id;

        $items = Labels::find($label_id);

        $items->delete();

        Cache::forget('labels_count');

        Labels::deleteLabelAssignedAs($label_id);

        Cache::forget('all_labels');

        return redirect()->route('labels.index')
            ->with('success', 'Label was deleted Successfully.');
    }
}
