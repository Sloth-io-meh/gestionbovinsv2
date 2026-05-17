<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Etable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_create_etable_page(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('etables.create'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_create_etable_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('etables.create'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_store_etable(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->post(route('etables.store'), [
            'id_etab' => 1,
            'nom' => 'Test Etable',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('etables', 0);
    }

    public function test_admin_can_store_etable(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('etables.store'), [
            'id_etab' => 1,
            'nom' => 'Test Etable',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('etables', ['nom' => 'Test Etable']);
    }
}
