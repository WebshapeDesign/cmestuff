<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Create extends Component
{
    public Vehicle $vehicle;

    public function mount()
    {
        $this->vehicle = new Vehicle();
    }

    public function save()
    {
        $this->validate([
            'vehicle.registration_number' => 'required|string|max:255',
            'vehicle.make' => 'required|string|max:255',
            'vehicle.model' => 'nullable|string|max:255',
            'vehicle.year' => 'nullable|integer',
        ]);

        $this->vehicle->user_id = auth()->id();
        $this->vehicle->save();

        session()->flash('success', 'Vehicle created successfully.');

        return redirect()->route('vehicles');
    }

    public function render()
    {
        return view('livewire.vehicles.create');
    }
}
