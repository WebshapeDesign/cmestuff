<?php

namespace App\Livewire\VanLogs;

use Livewire\Component;
use App\Models\VanLog;

class Index extends Component
{
    public $vanLogs;

    public function mount()
    {
        $this->vanLogs = VanLog::with('vehicle', 'user')->latest()->get();
    }

    public function render()
    {
        return view('livewire.van-logs.index');
    }
}
