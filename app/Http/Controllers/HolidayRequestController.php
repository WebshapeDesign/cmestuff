<?php

namespace App\Http\Controllers;

use App\Models\HolidayRequest;
use App\Models\User;
use Illuminate\Http\Request;

class HolidayRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $holidayRequests = HolidayRequest::with('user')->latest()->paginate(10);
        } else {
            $holidayRequests = auth()->user()->holidayRequests()->latest()->paginate(10);
        }
        return view('holidays.index', compact('holidayRequests'));
    }

    public function create()
    {
        return view('holidays.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['days_requested'] = $this->calculateDays($validated['start_date'], $validated['end_date']);

        HolidayRequest::create($validated);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request submitted successfully.');
    }

    public function show(HolidayRequest $holidayRequest)
    {
        $this->authorize('view', $holidayRequest);
        return view('holidays.show', compact('holidayRequest'));
    }

    public function edit(HolidayRequest $holidayRequest)
    {
        $this->authorize('update', $holidayRequest);
        return view('holidays.edit', compact('holidayRequest'));
    }

    public function update(Request $request, HolidayRequest $holidayRequest)
    {
        $this->authorize('update', $holidayRequest);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $validated['days_requested'] = $this->calculateDays($validated['start_date'], $validated['end_date']);

        $holidayRequest->update($validated);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request updated successfully.');
    }

    public function approve(HolidayRequest $holidayRequest)
    {
        $this->authorize('approve', $holidayRequest);
        
        $holidayRequest->update(['status' => 'approved']);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request approved successfully.');
    }

    public function reject(HolidayRequest $holidayRequest)
    {
        $this->authorize('approve', $holidayRequest);
        
        $holidayRequest->update(['status' => 'rejected']);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request rejected successfully.');
    }

    private function calculateDays($startDate, $endDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        return $start->diffInDays($end) + 1;
    }
} 