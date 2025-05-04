<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\HolidayRequest;
use App\Notifications\HolidayRequestStatusChanged;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

class HolidayRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_create_holiday_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test('holiday-requests')
            ->set('start_date', Carbon::now()->addDays(1)->format('Y-m-d'))
            ->set('end_date', Carbon::now()->addDays(5)->format('Y-m-d'))
            ->call('create');

        $this->assertDatabaseHas('holiday_requests', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_holiday_request()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($admin);

        Livewire::test('holiday-requests')
            ->call('approve', $holidayRequest->id);

        $this->assertDatabaseHas('holiday_requests', [
            'id' => $holidayRequest->id,
            'status' => 'approved',
        ]);

        Notification::assertSentTo($user, HolidayRequestStatusChanged::class);
    }

    public function test_admin_can_deny_holiday_request()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($admin);

        Livewire::test('holiday-requests')
            ->call('deny', $holidayRequest->id);

        $this->assertDatabaseHas('holiday_requests', [
            'id' => $holidayRequest->id,
            'status' => 'denied',
        ]);

        Notification::assertSentTo($user, HolidayRequestStatusChanged::class);
    }

    public function test_user_cannot_approve_own_holiday_request()
    {
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test('holiday-requests')
            ->call('approve', $holidayRequest->id);

        $this->assertDatabaseHas('holiday_requests', [
            'id' => $holidayRequest->id,
            'status' => 'pending',
        ]);
    }

    public function test_holiday_requests_are_listed_in_table()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($admin);

        $response = Livewire::test('holiday-requests')
            ->assertSee($user->name)
            ->assertSee($holidayRequest->start_date->format('d/m/Y'))
            ->assertSee($holidayRequest->end_date->format('d/m/Y'))
            ->assertSee($holidayRequest->days_requested)
            ->assertSee(ucfirst($holidayRequest->status));
    }

    public function test_user_can_edit_own_pending_holiday_request()
    {
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $this->actingAs($user);

        $newStartDate = Carbon::now()->addDays(10)->format('Y-m-d');
        $newEndDate = Carbon::now()->addDays(15)->format('Y-m-d');

        Livewire::test('holiday-requests')
            ->call('edit', $holidayRequest->id)
            ->set('start_date', $newStartDate)
            ->set('end_date', $newEndDate)
            ->call('update');

        $this->assertDatabaseHas('holiday_requests', [
            'id' => $holidayRequest->id,
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
        ]);
    }

    public function test_user_cannot_edit_approved_holiday_request()
    {
        $user = User::factory()->create();
        $holidayRequest = HolidayRequest::factory()->create([
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        $this->actingAs($user);

        $response = Livewire::test('holiday-requests')
            ->call('edit', $holidayRequest->id);

        $this->assertFalse($response->get('showModal'));
    }

    public function test_holiday_request_validation_works()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = Livewire::test('holiday-requests')
            ->set('start_date', Carbon::now()->subDays(1)->format('Y-m-d'))
            ->set('end_date', Carbon::now()->addDays(1)->format('Y-m-d'))
            ->call('create');

        $response->assertHasErrors(['start_date']);
    }
} 