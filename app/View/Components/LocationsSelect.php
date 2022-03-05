<?php

namespace App\View\Components;

use App\Models\Locations;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LocationsSelect extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $all_locations = Cache::rememberForever('all_locations', function () {
            return Locations::all();
        });
        return view('components.locations-select', [
            'locations' => $all_locations
        ]);
    }
}
