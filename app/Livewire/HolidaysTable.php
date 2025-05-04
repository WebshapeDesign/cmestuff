<?php

namespace App\Livewire;

use App\Models\Holiday;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class HolidaysTable extends Component
{
    use WithPagination;

    public $selectedHolidays = [];
    public $filters = [
        'dateRange' => '30',
        'comparisonPeriod' => 'previous',
        'status' => null,
        'type' => null,
        'employee' => null,
    ];

    public $stats = [
        [
            'title' => 'Total Holidays',
            'value' => '0',
            'trendUp' => true,
            'trend' => '12%',
        ],
        [
            'title' => 'Pending Requests',
            'value' => '0',
            'trendUp' => false,
            'trend' => '5%',
        ],
        [
            'title' => 'Average Duration',
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
        $query = Holiday::query();
        
        // Apply filters
        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }
        if ($this->filters['type']) {
            $query->where('type', $this->filters['type']);
        }
        if ($this->filters['employee']) {
            $query->where('user_id', $this->filters['employee']);
        }

        // Calculate stats
        $totalHolidays = $query->count();
        $pendingRequests = $query->where('status', 'pending')->count();
        $averageDuration = $totalHolidays > 0 
            ? $query->avg(\DB::raw('DATEDIFF(end_date, start_date) + 1'))
            : 0;

        $this->stats = [
            [
                'title' => 'Total Holidays',
                'value' => number_format($totalHolidays),
                'trendUp' => true,
                'trend' => '12%',
            ],
            [
                'title' => 'Pending Requests',
                'value' => number_format($pendingRequests),
                'trendUp' => false,
                'trend' => '5%',
            ],
            [
                'title' => 'Average Duration',
                'value' => number_format($averageDuration, 1) . ' days',
                'trendUp' => true,
                'trend' => '8%',
            ],
        ];
    }

    public function render()
    {
        $query = Holiday::with(['user'])
            ->orderBy('start_date', 'desc');

        // Apply filters
        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }
        if ($this->filters['type']) {
            $query->where('type', $this->filters['type']);
        }
        if ($this->filters['employee']) {
            $query->where('user_id', $this->filters['employee']);
        }

        $holidays = $query->paginate(10);

        return view('livewire.holidays-table', [
            'holidays' => $holidays,
            'employees' => User::all(),
        ]);
    }
} 