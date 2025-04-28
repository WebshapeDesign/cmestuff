<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $week_commencing;
    public $entries = [];
    public $materials;
    public $others;
    public $total_expenses;

    public function mount()
    {
        $this->week_commencing = now()->startOfWeek()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'week_commencing' => 'required|date',
            'entries' => 'required|array',
        ]);

        Timesheet::create([
            'user_id' => Auth::id(),
            'week_commencing' => $this->week_commencing,
            'entries' => $this->entries,
            'materials' => $this->materials,
            'others' => $this->others,
            'total_expenses' => ($this->materials ?? 0) + ($this->others ?? 0),
        ]);

        return redirect()->route('timesheets.index')->with('success', 'Timesheet created successfully.');
    }

    public function render()
    {
        return view('livewire.timesheets.create');
    }
}
