<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        $timesheets = auth()->user()->isAdmin() 
            ? Timesheet::with('user')->latest()->paginate(10)
            : auth()->user()->timesheets()->latest()->paginate(10);

        return view('timesheets.index', compact('timesheets'));
    }

    public function create()
    {
        return view('timesheets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'week_start_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Timesheet::create($validated);

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet created successfully.');
    }

    public function show(Timesheet $timesheet)
    {
        $this->authorize('view', $timesheet);
        return view('timesheets.show', compact('timesheet'));
    }

    public function edit(Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);
        return view('timesheets.edit', compact('timesheet'));
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);

        $validated = $request->validate([
            'week_start_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $timesheet->update($validated);

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet updated successfully.');
    }

    public function destroy(Timesheet $timesheet)
    {
        $this->authorize('delete', $timesheet);
        $timesheet->delete();

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet deleted successfully.');
    }
} 