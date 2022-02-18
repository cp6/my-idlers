<?php

namespace App\View\Components;

use App\Models\Labels;
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
        return view('components.labels-select', [
            'labels' => Labels::all()
        ]);
    }
}
