<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VanLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;

class VanLogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_van_logs_index_loads()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();
        VanLog::factory()->create(['vehicle_id' => $vehicle->id, 'user_id' => $user->id]);
        
        $this->actingAs($user)
            ->get(route('van-logs.index'))
            ->assertStatus(200)
            ->assertSee($vehicle->registration);
    }

    public function test_van_log_creation_works()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();
        
        Livewire::actingAs($user)
            ->test('van-logs')
            ->set('vehicle_id', $vehicle->id)
            ->set('vehicle_mileage', 1000)
            ->set('oil_level_action', 'Checked')
            ->set('oil_level_signed', 'John Doe')
            ->call('save')
            ->assertSet('success', 'Van Log saved successfully.');
    }

    public function test_van_log_validation_works()
    {
        $user = User::factory()->create();
        
        Livewire::actingAs($user)
            ->test('van-logs')
            ->call('save')
            ->assertHasErrors(['vehicle_id']);
    }

    public function test_van_log_error_handling()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();
        
        // Mock a database error
        $this->mock(VanLog::class, function ($mock) {
            $mock->shouldReceive('create')->andThrow(new \Exception('Database error'));
        });
        
        Livewire::actingAs($user)
            ->test('van-logs')
            ->set('vehicle_id', $vehicle->id)
            ->set('vehicle_mileage', 1000)
            ->call('save')
            ->assertSet('error', 'An error occurred while saving the van log.');
    }

    public function test_vehicle_mileage_updates()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['mileage' => 5000]);
        
        Livewire::actingAs($user)
            ->test('van-logs')
            ->set('vehicle_id', $vehicle->id)
            ->assertSet('vehicle_mileage', 5000);
    }
} 