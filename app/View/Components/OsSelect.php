<?php

namespace App\View\Components;

use App\Models\OS;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class OsSelect extends Component
{
    public function render()
    {
        $all_os = Cache::rememberForever('all_os', function () {
            return OS::all();
        });
        return view('components.os-select', [
            'os' => $all_os
        ]);
    }
}
