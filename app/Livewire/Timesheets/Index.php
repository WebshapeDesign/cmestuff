<?php

namespace App\Livewire\Timesheets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Timesheet;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.timesheets.index', [
            'timesheets' => Timesheet::where('user_id', auth()->id())->latest()->paginate(10),
        ]);
    }
}
