<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        return view('timesheets.index');
    }

    public function create()
    {
        return view('timesheets.create');
    }

    public function edit(Timesheet $timesheet)
    {
        return view('timesheets.edit', compact('timesheet'));
    }
} 