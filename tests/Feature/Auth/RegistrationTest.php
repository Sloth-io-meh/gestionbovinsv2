<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_route_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_self_registration_post_is_disabled(): void
    {
        $this->post('/register', [
            'name'                  => 'Intruder',
            'email'                 => 'intruder@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();

        $this->assertDatabaseMissing('users', ['email' => 'intruder@example.com']);
        $this->assertGuest();
    }
}
