<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VanLog;
use App\Models\MileageLog;
use App\Models\Timesheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class WeeklyFormsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_weekly_forms_are_auto_created()
    {
        // Create a user and assign a vehicle
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        // Set the current date to a Sunday
        $sunday = Carbon::parse('next sunday');
        Carbon::setTestNow($sunday);

        // Run the weekly form creation command
        $this->artisan('forms:create-weekly')
            ->assertExitCode(0);

        // Check that new forms were created
        $this->assertDatabaseHas('van_logs', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'week_start' => $sunday->startOfWeek()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('mileage_logs', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'week_start' => $sunday->startOfWeek()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('timesheets', [
            'user_id' => $user->id,
            'week_start' => $sunday->startOfWeek()->format('Y-m-d'),
        ]);
    }

    public function test_forms_are_not_created_for_unassigned_vehicles()
    {
        // Create a user and an unassigned vehicle
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => null]);

        // Set the current date to a Sunday
        $sunday = Carbon::parse('next sunday');
        Carbon::setTestNow($sunday);

        // Run the weekly form creation command
        $this->artisan('forms:create-weekly')
            ->assertExitCode(0);

        // Check that no forms were created for the unassigned vehicle
        $this->assertDatabaseMissing('van_logs', [
            'vehicle_id' => $vehicle->id,
        ]);

        $this->assertDatabaseMissing('mileage_logs', [
            'vehicle_id' => $vehicle->id,
        ]);
    }

    public function test_forms_cannot_be_submitted_without_checking()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $vanLog = VanLog::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'checked' => false,
        ]);

        $this->actingAs($user)
            ->post(route('van-logs.submit', $vanLog))
            ->assertStatus(403)
            ->assertJson(['message' => 'Form must be checked before submission']);
    }

    public function test_forms_are_marked_as_late_after_tuesday()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        
        // Create a form for last week
        $lastWeek = Carbon::now()->subWeek();
        $vanLog = VanLog::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'week_start' => $lastWeek->startOfWeek()->format('Y-m-d'),
            'submitted_at' => null,
        ]);

        // Set current date to Wednesday of the following week
        $wednesday = $lastWeek->addDays(10);
        Carbon::setTestNow($wednesday);

        // Run the check for late forms
        $this->artisan('forms:check-late')
            ->assertExitCode(0);

        // Verify the form is marked as late
        $this->assertDatabaseHas('van_logs', [
            'id' => $vanLog->id,
            'is_late' => true,
        ]);
    }
} 