<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use App\Models\User;

class Create extends Component
{
    public Vehicle $vehicle;

    public function mount()
    {
        $this->vehicle = new Vehicle();
    }

    public function save()
    {
        logger('Vehicle save triggered');
        $this->validate([
            'vehicle.registration_number' => 'required|string|max:12',
            'vehicle.make' => 'nullable|string|max:20',
            'vehicle.model' => 'nullable|string|max:20',
            'vehicle.year' => 'nullable|integer|min:0',
            'vehicle.starting_mileage' => 'nullable|integer|min:0',
        ]);

        $this->vehicle->user_id = auth()->id();
        $this->vehicle->save();

        session()->flash('success', 'Vehicle created successfully.');

        return redirect()->route('vehicles');
    }

    public function render()
    {
        return view('livewire.vehicles.create', [
            'users' => User::orderBy('name')->get(),
        ]);
    }
}
