<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_is_not_admin_by_default()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->admin_status);
    }

    public function test_user_is_admin_when_role_is_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($admin->admin_status);
    }

    public function test_admin_status_attribute_returns_correct_value()
    {
        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertFalse($user->admin_status);
        $this->assertTrue($admin->admin_status);
    }

    public function test_user_has_vehicles_relationship()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->vehicles());
    }

    public function test_user_has_timesheets_relationship()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->timesheets());
    }

    public function test_user_has_holidays_relationship()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->holidays());
    }
} 