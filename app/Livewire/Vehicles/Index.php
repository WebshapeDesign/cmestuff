<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;
use App\Models\Vehicle;

class Index extends Component
{
    public $sortBy = 'registration_number'; // Default sort
    public $sortDirection = 'asc';

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $vehicles = Vehicle::orderBy($this->sortBy, $this->sortDirection)->get();

        return view('livewire.vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }
}
