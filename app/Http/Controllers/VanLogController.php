<?php

namespace App\Http\Controllers;

use App\Models\VanLog;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VanLogController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $vanLogs = VanLog::with('vehicle', 'user')->latest()->paginate(10);
        } else {
            $vanLogs = auth()->user()->vanLogs()->with('vehicle')->latest()->paginate(10);
        }
        return view('van-logs.index', compact('vanLogs'));
    }

    public function create()
    {
        $vehicles = auth()->user()->isAdmin() 
            ? Vehicle::all() 
            : Vehicle::where('assigned_user_id', auth()->id())->get();
            
        return view('van-logs.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'week_start_date' => 'required|date',
            'oil_level_action' => 'required|in:Checked,Topped Up',
            'oil_level_signed' => 'required|string|max:255',
            'water_level_action' => 'required|in:Checked,Topped Up',
            'water_level_signed' => 'required|string|max:255',
            'tyres_action' => 'required|in:Checked,Replaced',
            'tyres_signed' => 'required|string|max:255',
            'screen_action' => 'required|in:Checked,Replaced',
            'screen_signed' => 'required|string|max:255',
            'vehicle_defects' => 'nullable|string',
            'van_items_check' => 'array',
            'ppe_check' => 'array',
            'is_checked' => 'boolean',
            'is_submitted' => 'boolean',
            'is_late' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        
        VanLog::create($validated);

        return redirect()->route('van-logs.index')
            ->with('success', 'Van log created successfully.');
    }

    public function show(VanLog $vanLog)
    {
        $this->authorize('view', $vanLog);
        return view('van-logs.show', compact('vanLog'));
    }

    public function edit(VanLog $vanLog)
    {
        $this->authorize('update', $vanLog);
        
        $vehicles = auth()->user()->isAdmin() 
            ? Vehicle::all() 
            : Vehicle::where('assigned_user_id', auth()->id())->get();
            
        return view('van-logs.edit', compact('vanLog', 'vehicles'));
    }

    public function update(Request $request, VanLog $vanLog)
    {
        $this->authorize('update', $vanLog);

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'week_start_date' => 'required|date',
            'oil_level_action' => 'required|in:Checked,Topped Up',
            'oil_level_signed' => 'required|string|max:255',
            'water_level_action' => 'required|in:Checked,Topped Up',
            'water_level_signed' => 'required|string|max:255',
            'tyres_action' => 'required|in:Checked,Replaced',
            'tyres_signed' => 'required|string|max:255',
            'screen_action' => 'required|in:Checked,Replaced',
            'screen_signed' => 'required|string|max:255',
            'vehicle_defects' => 'nullable|string',
            'van_items_check' => 'array',
            'ppe_check' => 'array',
            'is_checked' => 'boolean',
            'is_submitted' => 'boolean',
            'is_late' => 'boolean',
        ]);

        $vanLog->update($validated);

        return redirect()->route('van-logs.index')
            ->with('success', 'Van log updated successfully.');
    }
} 