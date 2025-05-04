<?php

namespace App\Http\Controllers;

use App\Models\HolidayRequest;
use App\Models\User;
use Illuminate\Http\Request;

class HolidayRequestController extends Controller
{
    public function index()
    {
        $holidayRequests = auth()->user()->isAdmin()
            ? HolidayRequest::with('user')->latest()->paginate(10)
            : auth()->user()->holidayRequests()->latest()->paginate(10);

        return view('holidays.index', compact('holidayRequests'));
    }

    public function create()
    {
        $users = auth()->user()->isAdmin() ? User::all() : null;
        return view('holidays.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // If user_id is not provided or user is not admin, use the authenticated user
        if (!auth()->user()->isAdmin() || !isset($validated['user_id'])) {
            $validated['user_id'] = auth()->id();
        }

        $holidayRequest = HolidayRequest::create($validated);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request created successfully.');
    }

    public function show(HolidayRequest $holidayRequest)
    {
        $this->authorize('view', $holidayRequest);
        return view('holidays.show', compact('holidayRequest'));
    }

    public function edit(HolidayRequest $holidayRequest)
    {
        $this->authorize('update', $holidayRequest);
        $users = auth()->user()->isAdmin() ? User::all() : null;
        return view('holidays.edit', compact('holidayRequest', 'users'));
    }

    public function update(Request $request, HolidayRequest $holidayRequest)
    {
        $this->authorize('update', $holidayRequest);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // If user is not admin, ensure they can't change the user_id
        if (!auth()->user()->isAdmin()) {
            unset($validated['user_id']);
        }

        $holidayRequest->update($validated);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request updated successfully.');
    }

    public function destroy(HolidayRequest $holidayRequest)
    {
        $this->authorize('delete', $holidayRequest);
        $holidayRequest->delete();

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday request deleted successfully.');
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
} 