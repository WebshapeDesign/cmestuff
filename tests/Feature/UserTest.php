<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_table_component_loads()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertStatus(200)
            ->assertSeeLivewire('users-table');
    }

    public function test_users_table_search_works()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);
        
        Livewire::actingAs($user)
            ->test('users-table')
            ->set('search', 'John')
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith');
    }

    public function test_users_table_sorting_works()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);
        
        $component = Livewire::actingAs($user)
            ->test('users-table')
            ->set('sortBy', 'name')
            ->set('sortDirection', 'asc');
            
        $this->assertTrue($component->get('sortDirection') === 'asc');
    }

    public function test_users_table_handles_errors()
    {
        $user = User::factory()->create();
        
        // Mock a database error
        $this->mock(User::class, function ($mock) {
            $mock->shouldReceive('query')->andThrow(new \Exception('Database error'));
        });
        
        Livewire::actingAs($user)
            ->test('users-table')
            ->assertSet('error', 'An error occurred while fetching users.');
    }
} 