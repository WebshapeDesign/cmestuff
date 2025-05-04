<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Show extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle): void
    {
        // Access control: only allow Admins or the assigned user
        if (!auth()->user()->isAdmin() && $vehicle->user_id !== auth()->id()) {
            abort(403, 'You are not authorised to view this vehicle.');
        }

        $this->vehicle = $vehicle;
    }

    public function render()
    {
        return view('livewire.vehicles.show');
    }
}
