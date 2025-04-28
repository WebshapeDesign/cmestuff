<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.mileage-logs.index', [
            'mileageLogs' => MileageLog::with('vehicle', 'user')->latest()->get(),
        ]);
    }
}
