<?php

namespace App\View\Components;

use App\Models\OS;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class OsSelect extends Component
{
    public function render()
    {
        return view('components.os-select', [
            'os' => OS::allOS()->toArray()
        ]);
    }
}
