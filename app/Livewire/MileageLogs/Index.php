<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Livewire\Component;

class Index extends Component
{
    public $sortBy = 'date';
    public $sortDirection = 'desc';

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
        return view('livewire.mileage-logs.index', [
            'mileageLogs' => MileageLog::with('vehicle', 'user')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
