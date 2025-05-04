<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VanLog;
use App\Models\MileageLog;
use App\Models\Timesheet;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateWeeklyForms extends Command
{
    protected $signature = 'forms:create-weekly';
    protected $description = 'Create weekly forms for all users and their assigned vehicles';

    public function handle()
    {
        $this->info('Creating weekly forms...');

        $weekStart = Carbon::now()->startOfWeek();
        
        // Create timesheets for all users
        User::all()->each(function ($user) use ($weekStart) {
            Timesheet::firstOrCreate([
                'user_id' => $user->id,
                'week_start' => $weekStart->format('Y-m-d'),
            ]);
        });

        // Create vehicle-related forms for assigned vehicles
        Vehicle::whereNotNull('user_id')->with('user')->get()->each(function ($vehicle) use ($weekStart) {
            // Create van log
            VanLog::firstOrCreate([
                'vehicle_id' => $vehicle->id,
                'user_id' => $vehicle->user_id,
                'week_start' => $weekStart->format('Y-m-d'),
            ]);

            // Create mileage log
            MileageLog::firstOrCreate([
                'vehicle_id' => $vehicle->id,
                'user_id' => $vehicle->user_id,
                'week_start' => $weekStart->format('Y-m-d'),
                'starting_mileage' => $vehicle->current_mileage,
            ]);
        });

        $this->info('Weekly forms created successfully!');
    }
} 