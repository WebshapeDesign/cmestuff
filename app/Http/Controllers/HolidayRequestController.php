<?php

namespace App\Http\Controllers;

use App\Models\HolidayRequest;
use Illuminate\Http\Request;

class HolidayRequestController extends Controller
{
    public function index()
    {
        return view('holidays.index');
    }
} 