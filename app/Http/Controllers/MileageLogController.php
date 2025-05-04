<?php

namespace App\Http\Controllers;

use App\Models\MileageLog;
use Illuminate\Http\Request;

class MileageLogController extends Controller
{
    public function index()
    {
        return view('mileage-logs.index');
    }

    public function create()
    {
        return view('mileage-logs.create');
    }

    public function edit(MileageLog $mileageLog)
    {
        return view('mileage-logs.edit', compact('mileageLog'));
    }
} 