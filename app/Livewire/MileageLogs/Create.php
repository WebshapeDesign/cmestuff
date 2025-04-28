<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use App\Models\Vehicle;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $vehicle_id;
    public $user_id;
    public $date;
    public $entries = [];
    public $saved = false;

    public function mount()
    {
        $this->date = today()->format('Y-m-d');
        $this->entries = [
            ['date' => today()->format('Y-m-d'), 'time' => '', 'purpose' => '', 'location' => '', 'start' => '', 'finish' => '', 'total_mileage' => 0],
        ];
    }

    public function addEntry()
    {
        $this->entries[] = ['date' => today()->format('Y-m-d'), 'time' => '', 'purpose' => '', 'location' => '', 'start' => '', 'finish' => '', 'total_mileage' => 0];
    }

    public function updatedEntries($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if (in_array($field, ['start', 'finish']) && isset($this->entries[$index]['start'], $this->entries[$index]['finish'])) {
            $start = (float) $this->entries[$index]['start'];
            $finish = (float) $this->entries[$index]['finish'];
            $this->entries[$index]['total_mileage'] = max(0, $finish - $start);
        }
    }

    public function saveDraft()
    {
        $this->saved = true;
        session()->flash('message', 'Draft saved. Don\'t forget to submit!');
    }

    public function submit()
    {
        $mileageLog = MileageLog::create([
            'vehicle_id' => $this->vehicle_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'entries' => $this->entries,
        ]);

        return redirect()->route('mileage-logs.index')->with('success', 'Mileage Log submitted successfully.');
    }

    public function render()
    {
        return view('livewire.mileage-logs.create', [
            'vehicles' => Vehicle::all(),
            'users' => User::all(),
        ]);
    }
}
