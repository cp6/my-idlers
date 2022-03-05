<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use Illuminate\Http\Request;
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

        return redirect()->route('labels.index')
            ->with('success', 'Label Created Successfully.');
    }

    public function show(Labels $label)
    {
        return view('labels.show', compact(['label']));
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

        Labels::deleteLabelAssignedAs($label_id);

        return redirect()->route('labels.index')
            ->with('success', 'Label was deleted Successfully.');
    }
}
