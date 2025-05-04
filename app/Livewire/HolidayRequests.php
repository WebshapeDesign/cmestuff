<?php

namespace App\Livewire;

use App\Models\HolidayRequest;
use App\Models\User;
use App\Notifications\HolidayRequestStatusChanged;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class HolidayRequests extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;
    public $days_requested;
    public $status = 'pending';
    public $selectedRequest;
    public $showModal = false;
    public $modalType = 'create';
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->addDays(1)->format('Y-m-d');
    }

    public function updatedStartDate()
    {
        if ($this->start_date && $this->end_date) {
            $this->calculateDaysRequested();
        }
    }

    public function updatedEndDate()
    {
        if ($this->start_date && $this->end_date) {
            $this->calculateDaysRequested();
        }
    }

    public function calculateDaysRequested()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $this->days_requested = $start->diffInDays($end) + 1;
    }

    public function create()
    {
        $this->validate();

        HolidayRequest::create([
            'user_id' => auth()->id(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'days_requested' => $this->days_requested,
            'status' => 'pending',
        ]);

        $this->reset(['start_date', 'end_date', 'days_requested', 'showModal']);
        session()->flash('success', 'Holiday request submitted successfully.');
    }

    public function edit(HolidayRequest $holidayRequest)
    {
        $this->selectedRequest = $holidayRequest;
        $this->start_date = $holidayRequest->start_date->format('Y-m-d');
        $this->end_date = $holidayRequest->end_date->format('Y-m-d');
        $this->days_requested = $holidayRequest->days_requested;
        $this->modalType = 'edit';
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->selectedRequest->update([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'days_requested' => $this->days_requested,
        ]);

        $this->reset(['start_date', 'end_date', 'days_requested', 'showModal', 'selectedRequest']);
        session()->flash('success', 'Holiday request updated successfully.');
    }

    public function approve(HolidayRequest $holidayRequest)
    {
        if (auth()->user()->isAdmin()) {
            $holidayRequest->update(['status' => 'approved']);
            $holidayRequest->user->notify(new HolidayRequestStatusChanged($holidayRequest));
            session()->flash('success', 'Holiday request approved successfully.');
        }
    }

    public function deny(HolidayRequest $holidayRequest)
    {
        if (auth()->user()->isAdmin()) {
            $holidayRequest->update(['status' => 'denied']);
            $holidayRequest->user->notify(new HolidayRequestStatusChanged($holidayRequest));
            session()->flash('success', 'Holiday request denied successfully.');
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = HolidayRequest::query()
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when(auth()->user()->isAdmin(), function ($query) {
                $query->with('user');
            }, function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.holiday-requests', [
            'holidayRequests' => $query->paginate(10),
        ]);
    }
} 