<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use App\Models\Vehicle;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $mileageLog;
    public $vehicle_id;
    public $user_id;
    public $date;
    public $entries = [];

    public function mount(MileageLog $mileageLog)
    {
        $this->mileageLog = $mileageLog;
        $this->vehicle_id = $mileageLog->vehicle_id;
        $this->user_id = $mileageLog->user_id;
        $this->date = $mileageLog->date;
        $this->entries = $mileageLog->entries;
    }

    public function save()
    {
        $this->mileageLog->update([
            'vehicle_id' => $this->vehicle_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'entries' => $this->entries,
        ]);

        return redirect()->route('mileage-logs.index')->with('success', 'Mileage Log updated successfully.');
    }

    public function render()
    {
        return view('livewire.mileage-logs.edit', [
            'vehicles' => Vehicle::all(),
            'users' => User::all(),
        ]);
    }
}
