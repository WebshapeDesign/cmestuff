<?php

namespace App\Livewire;

use App\Models\MileageLog;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class MileageLogsTable extends Component
{
    use WithPagination;

    public $selectedLogs = [];
    public $filters = [
        'dateRange' => '30',
        'comparisonPeriod' => 'previous',
        'vehicle' => null,
        'driver' => null,
        'status' => null,
    ];

    public $stats = [
        [
            'title' => 'Total Mileage',
            'value' => '0',
            'trendUp' => true,
            'trend' => '12%',
        ],
        [
            'title' => 'Average Daily Mileage',
            'value' => '0',
            'trendUp' => false,
            'trend' => '5%',
        ],
        [
            'title' => 'Total Logs',
            'value' => '0',
            'trendUp' => true,
            'trend' => '8%',
        ],
    ];

    public function mount()
    {
        $this->updateStats();
    }

    public function updatedFilters()
    {
        $this->resetPage();
        $this->updateStats();
    }

    protected function updateStats()
    {
        $query = MileageLog::query();
        
        // Apply filters
        if ($this->filters['vehicle']) {
            $query->where('vehicle_id', $this->filters['vehicle']);
        }
        if ($this->filters['driver']) {
            $query->where('user_id', $this->filters['driver']);
        }
        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        // Calculate stats
        $totalMileage = $query->sum('end_mileage - start_mileage');
        $totalLogs = $query->count();
        $averageDailyMileage = $totalLogs > 0 ? $totalMileage / $totalLogs : 0;

        $this->stats = [
            [
                'title' => 'Total Mileage',
                'value' => number_format($totalMileage),
                'trendUp' => true,
                'trend' => '12%',
            ],
            [
                'title' => 'Average Daily Mileage',
                'value' => number_format($averageDailyMileage, 1),
                'trendUp' => false,
                'trend' => '5%',
            ],
            [
                'title' => 'Total Logs',
                'value' => number_format($totalLogs),
                'trendUp' => true,
                'trend' => '8%',
            ],
        ];
    }

    public function render()
    {
        $query = MileageLog::with(['vehicle', 'user'])
            ->orderBy('date', 'desc');

        // Apply filters
        if ($this->filters['vehicle']) {
            $query->where('vehicle_id', $this->filters['vehicle']);
        }
        if ($this->filters['driver']) {
            $query->where('user_id', $this->filters['driver']);
        }
        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        $logs = $query->paginate(10);

        return view('livewire.mileage-logs-table', [
            'logs' => $logs,
            'vehicles' => Vehicle::all(),
            'drivers' => User::where('role', 'driver')->get(),
        ]);
    }
} 