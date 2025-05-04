<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('assignedUser')->latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $users = User::all();
        return view('vehicles.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration' => 'required|string|max:255|unique:vehicles',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,maintenance',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('assignedUser', 'vanLogs', 'mileageLogs');
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $users = User::all();
        return view('vehicles.edit', compact('vehicle', 'users'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'registration' => 'required|string|max:255|unique:vehicles,registration,' . $vehicle->id,
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,maintenance',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }
} 