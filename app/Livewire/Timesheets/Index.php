<?php

namespace App\Livewire\Timesheets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Timesheet;

class Index extends Component
{
    use WithPagination;

    public $sortBy = 'week_commencing';
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
        return view('livewire.timesheets.index', [
            'timesheets' => Timesheet::where('user_id', auth()->id())
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
