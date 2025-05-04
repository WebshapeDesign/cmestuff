<?php

namespace App\Console\Commands;

use App\Models\VanLog;
use App\Models\MileageLog;
use App\Models\Timesheet;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckLateForms extends Command
{
    protected $signature = 'forms:check-late';
    protected $description = 'Check for and mark late forms';

    public function handle()
    {
        $this->info('Checking for late forms...');

        $cutoffDate = Carbon::now()->subDays(10); // Tuesday of the following week

        // Check van logs
        VanLog::whereNull('submitted_at')
            ->where('week_start', '<=', $cutoffDate->format('Y-m-d'))
            ->where('is_late', false)
            ->update(['is_late' => true]);

        // Check mileage logs
        MileageLog::whereNull('submitted_at')
            ->where('week_start', '<=', $cutoffDate->format('Y-m-d'))
            ->where('is_late', false)
            ->update(['is_late' => true]);

        // Check timesheets
        Timesheet::whereNull('submitted_at')
            ->where('week_start', '<=', $cutoffDate->format('Y-m-d'))
            ->where('is_late', false)
            ->update(['is_late' => true]);

        $this->info('Late forms check completed!');
    }
} 