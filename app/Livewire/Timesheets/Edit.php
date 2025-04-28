<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $timesheet;

    public $week_commencing;
    public $entries = [];
    public $materials;
    public $others;
    public $total_expenses;

    public function mount(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
        $this->week_commencing = $timesheet->week_commencing->format('Y-m-d');
        $this->entries = $timesheet->entries;
        $this->materials = $timesheet->materials;
        $this->others = $timesheet->others;
        $this->total_expenses = $timesheet->total_expenses;
    }

    public function save()
    {
        $this->validate([
            'week_commencing' => 'required|date',
            'entries' => 'required|array',
        ]);

        $this->timesheet->update([
            'week_commencing' => $this->week_commencing,
            'entries' => $this->entries,
            'materials' => $this->materials,
            'others' => $this->others,
            'total_expenses' => ($this->materials ?? 0) + ($this->others ?? 0),
        ]);

        return redirect()->route('timesheets.index')->with('success', 'Timesheet updated successfully.');
    }

    public function render()
    {
        return view('livewire.timesheets.edit');
    }
}
