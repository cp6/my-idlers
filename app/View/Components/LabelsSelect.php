<?php

namespace App\View\Components;

use App\Models\Labels;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LabelsSelect extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $all_labels = Cache::rememberForever('all_labels', function () {
            return Labels::all();
        });
        return view('components.labels-select', [
            'labels' => $all_labels
        ]);
    }
}
