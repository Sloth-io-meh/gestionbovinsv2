<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuthorizationGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_gate_allows_admin_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->assertTrue(Gate::forUser($admin)->allows('admin'));
    }

    public function test_admin_gate_denies_non_admin_user(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->assertFalse(Gate::forUser($user)->allows('admin'));
    }
}
