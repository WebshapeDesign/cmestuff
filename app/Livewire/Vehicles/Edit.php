<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Edit extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle): void
    {
        // Access control: only allow editing if admin or owner
        if (!auth()->user()->isAdmin() && $vehicle->user_id !== auth()->id()) {
            abort(403, 'You are not authorised to edit this vehicle.');
        }

        $this->vehicle = $vehicle;
    }

    public function save(): void
    {
        $this->validate([
            'vehicle.registration_number' => 'required|string|max:255',
            'vehicle.make' => 'required|string|max:255',
            'vehicle.model' => 'nullable|string|max:255',
            'vehicle.year' => 'nullable|integer',
        ]);

        $this->vehicle->save();

        session()->flash('success', 'Vehicle updated successfully.');

        return redirect()->route('vehicles');
    }

    public function render()
    {
        return view('livewire.vehicles.edit');
    }
}
