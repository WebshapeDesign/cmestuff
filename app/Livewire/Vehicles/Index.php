<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sortBy = 'registration_number';
    public $sortDirection = 'asc';

    public function sort($field): void
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
        $query = Vehicle::query();

        // Role-based filtering
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $vehicles = $query
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }
}
