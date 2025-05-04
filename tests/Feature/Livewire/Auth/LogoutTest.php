<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Logout;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    public function test_logout_component_renders()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Logout::class)
            ->assertSee('Logout');
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Logout::class)
            ->call('logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_logout_button_shows_loading_state()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Logout::class)
            ->assertSee('Logout')
            ->assertDontSee('Logging out...')
            ->call('logout')
            ->assertSee('Logging out...')
            ->assertRedirect(route('login'));
    }
} 