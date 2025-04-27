<?php

namespace App\Livewire\Vehicles;


use Livewire\Component;
use App\Models\Vehicle;

class Show extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function render()
    {
        return view('livewire.vehicles.show');
    }
}
