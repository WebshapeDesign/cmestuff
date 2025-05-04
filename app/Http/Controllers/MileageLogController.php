<?php

namespace App\Http\Controllers;

use App\Models\MileageLog;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MileageLogController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $mileageLogs = MileageLog::with('vehicle', 'user')->latest()->paginate(10);
        } else {
            $mileageLogs = auth()->user()->mileageLogs()->with('vehicle')->latest()->paginate(10);
        }
        return view('mileage-logs.index', compact('mileageLogs'));
    }

    public function create()
    {
        $vehicles = auth()->user()->isAdmin() 
            ? Vehicle::all() 
            : Vehicle::where('assigned_user_id', auth()->id())->get();
            
        return view('mileage-logs.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'week_start_date' => 'required|date',
            'start_mileage' => 'required|integer|min:0',
            'end_mileage' => 'required|integer|min:0|gte:start_mileage',
            'notes' => 'nullable|string',
            'is_submitted' => 'boolean',
            'is_late' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        
        MileageLog::create($validated);

        return redirect()->route('mileage-logs.index')
            ->with('success', 'Mileage log created successfully.');
    }

    public function show(MileageLog $mileageLog)
    {
        $this->authorize('view', $mileageLog);
        return view('mileage-logs.show', compact('mileageLog'));
    }

    public function edit(MileageLog $mileageLog)
    {
        $this->authorize('update', $mileageLog);
        
        $vehicles = auth()->user()->isAdmin() 
            ? Vehicle::all() 
            : Vehicle::where('assigned_user_id', auth()->id())->get();
            
        return view('mileage-logs.edit', compact('mileageLog', 'vehicles'));
    }

    public function update(Request $request, MileageLog $mileageLog)
    {
        $this->authorize('update', $mileageLog);

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'week_start_date' => 'required|date',
            'start_mileage' => 'required|integer|min:0',
            'end_mileage' => 'required|integer|min:0|gte:start_mileage',
            'notes' => 'nullable|string',
            'is_submitted' => 'boolean',
            'is_late' => 'boolean',
        ]);

        $mileageLog->update($validated);

        return redirect()->route('mileage-logs.index')
            ->with('success', 'Mileage log updated successfully.');
    }
} 