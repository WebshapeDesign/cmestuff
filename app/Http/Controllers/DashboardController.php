<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $flaggedIssues = auth()->user()->isAdmin() 
            ? \App\Models\Issue::where('status', '!=', 'resolved')->get()
            : collect();

        return view('dashboard', compact('flaggedIssues'));
    }
} 