<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;
use App\Models\User;
use App\Models\Vehicle;

class Create extends Component
{
    public $registration = '';
    public $starting_mileage = '';
    public $make = '';
    public $model = '';
    public $current_mileage = '';
    public $user_id = '';

    public $makes = [
        'Ford', 'Mercedes', 'Renault', 'VW', 'Opel', 'Citroen', 'Peugeot',
    ];

    public $models = [
        'Transit', 'Sprinter', 'Berlingo', 'Vivaro', 'Transporter', 'Ranger', 'Vito',
    ];

    public function save()
    {
        $this->validate([
            'registration' => 'required|string|max:255',
            'starting_mileage' => 'required|numeric|min:0',
            'make' => 'required|string',
            'model' => 'required|string',
            'current_mileage' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Vehicle::create([
            'registration_number' => $this->registration,
            'starting_mileage' => $this->starting_mileage,
            'make' => $this->make,
            'model' => $this->model,
            'current_mileage' => $this->current_mileage,
            'user_id' => $this->user_id,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully!');
    }

    public function render()
    {
        return view('livewire.vehicles.create', [
            'users' => User::all(),
        ]);
    }
}
