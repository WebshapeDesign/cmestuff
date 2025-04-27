<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;
use App\Models\Vehicle;

class Index extends Component
{
    public function render()
    {
        return view('livewire.vehicles.index', [
            'vehicles' => Vehicle::all(),
        ]);
    }
}
