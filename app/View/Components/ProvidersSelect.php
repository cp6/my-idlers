<?php

namespace App\View\Components;

use App\Models\Providers;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class ProvidersSelect extends Component
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $all_providers = Cache::rememberForever('all_providers', function () {
            return Providers::all();
        });
        return view('components.providers-select', [
            'providers' => $all_providers
        ]);
    }
}
