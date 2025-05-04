<?php

namespace Tests\Feature\View\Components;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SidebarTest extends TestCase
{
    use DatabaseTransactions;

    public function test_sidebar_renders_for_regular_user()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Vehicles')
            ->assertSee('Van Logs')
            ->assertSee('Mileage Logs')
            ->assertSee('Timesheets')
            ->assertSee('Holidays')
            ->assertSee('Settings')
            ->assertDontSee('Users')
            ->assertDontSee('Admin');
    }

    public function test_sidebar_renders_for_admin_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Vehicles')
            ->assertSee('Van Logs')
            ->assertSee('Mileage Logs')
            ->assertSee('Timesheets')
            ->assertSee('Holidays')
            ->assertSee('Settings')
            ->assertSee('Users')
            ->assertSee('Admin');
    }

    public function test_sidebar_shows_correct_active_route()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('current');
    }

    public function test_sidebar_shows_user_profile()
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertSee('John Doe');
    }

    public function test_sidebar_shows_admin_badge_for_admin_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertSee('Admin')
            ->assertSee('blue');
    }
} 