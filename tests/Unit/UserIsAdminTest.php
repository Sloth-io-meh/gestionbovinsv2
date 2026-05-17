<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserIsAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_admin()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $this->assertTrue($user->is_admin);
    }

    public function test_user_is_not_admin_by_default()
    {
        $user = User::factory()->create();
        $this->assertFalse($user->fresh()->is_admin);
    }

    public function test_is_admin_is_cast_to_boolean()
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $this->assertIsBool($user->is_admin);
        $this->assertTrue($user->is_admin);

        $user->is_admin = 0;
        $user->save();
        $this->assertIsBool($user->fresh()->is_admin);
        $this->assertFalse($user->fresh()->is_admin);
    }
}
