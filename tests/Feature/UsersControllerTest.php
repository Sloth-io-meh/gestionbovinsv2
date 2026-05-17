<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    // ── helpers ──────────────────────────────────────────────────────────────

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function regularUser(): User
    {
        return User::factory()->create(['is_admin' => false]);
    }

    // ── access control ───────────────────────────────────────────────────────

    public function test_guest_is_redirected_from_users_index(): void
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_users_index(): void
    {
        $this->actingAs($this->regularUser())->get(route('users.index'))->assertForbidden();
    }

    public function test_admin_can_access_users_index(): void
    {
        $this->actingAs($this->admin())->get(route('users.index'))->assertOk();
    }

    public function test_non_admin_cannot_access_create_user(): void
    {
        $this->actingAs($this->regularUser())->get(route('users.create'))->assertForbidden();
    }

    public function test_admin_can_access_create_user(): void
    {
        $this->actingAs($this->admin())->get(route('users.create'))->assertOk();
    }

    public function test_non_admin_cannot_access_edit_user(): void
    {
        $target = $this->regularUser();
        $this->actingAs($this->regularUser())->get(route('users.edit', $target))->assertForbidden();
    }

    public function test_non_admin_cannot_access_reset_password(): void
    {
        $target = $this->regularUser();
        $this->actingAs($this->regularUser())
            ->get(route('users.edit-password', $target))
            ->assertForbidden();
    }

    // ── create & store ───────────────────────────────────────────────────────

    public function test_admin_can_create_user(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'New User',
            'email'                 => 'newuser@example.com',
            'password'              => 'SecurePass1!',
            'password_confirmation' => 'SecurePass1!',
            'nom'                   => 'User',
            'prenom'                => 'New',
            'tel'                   => '0600000000',
            'is_admin'              => false,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email'    => 'newuser@example.com',
            'is_admin' => false,
        ]);
    }

    public function test_admin_can_create_admin_user(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'New Admin',
            'email'                 => 'admin2@example.com',
            'password'              => 'SecurePass1!',
            'password_confirmation' => 'SecurePass1!',
            'is_admin'              => true,
        ]);

        $this->assertDatabaseHas('users', ['email' => 'admin2@example.com', 'is_admin' => true]);
    }

    public function test_store_rejects_short_password(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'Bad User',
            'email'                 => 'bad@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'bad@example.com']);
    }

    public function test_store_rejects_mismatched_passwords(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'Mismatch User',
            'email'                 => 'mismatch@example.com',
            'password'              => 'SecurePass1!',
            'password_confirmation' => 'DifferentPass1!',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'mismatch@example.com']);
    }

    public function test_store_rejects_duplicate_email(): void
    {
        $admin  = $this->admin();
        $existing = $this->regularUser();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'Duplicate',
            'email'                 => $existing->email,
            'password'              => 'SecurePass1!',
            'password_confirmation' => 'SecurePass1!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_hashed_on_create(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('users.store'), [
            'name'                  => 'Hash Test',
            'email'                 => 'hashtest@example.com',
            'password'              => 'PlainTextPass1!',
            'password_confirmation' => 'PlainTextPass1!',
        ]);

        $user = User::where('email', 'hashtest@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotEquals('PlainTextPass1!', $user->getAuthPassword());
        $this->assertTrue(Hash::check('PlainTextPass1!', $user->getAuthPassword()));
    }

    // ── update ───────────────────────────────────────────────────────────────

    public function test_admin_can_update_user(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();

        $response = $this->actingAs($admin)->put(route('users.update', $target), [
            'name'     => 'Updated Name',
            'email'    => $target->email,
            'is_admin' => false,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $target->id, 'name' => 'Updated Name']);
    }

    public function test_update_rejects_duplicate_email_of_another_user(): void
    {
        $admin  = $this->admin();
        $user1  = $this->regularUser();
        $user2  = $this->regularUser();

        $response = $this->actingAs($admin)->put(route('users.update', $user1), [
            'name'     => $user1->name,
            'email'    => $user2->email,
            'is_admin' => false,
        ]);

        $response->assertSessionHasErrors('email');
    }

    // ── password reset ───────────────────────────────────────────────────────

    public function test_admin_can_access_reset_password_page(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();

        $this->actingAs($admin)->get(route('users.edit-password', $target))->assertOk();
    }

    public function test_admin_can_reset_user_password(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();

        $response = $this->actingAs($admin)->patch(route('users.update-password', $target), [
            'password'              => 'NewSecurePass1!',
            'password_confirmation' => 'NewSecurePass1!',
        ]);

        $response->assertRedirect(route('users.show', $target));
        $target->refresh();
        $this->assertTrue(Hash::check('NewSecurePass1!', $target->password));
    }

    public function test_reset_password_rejects_short_password(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();

        $response = $this->actingAs($admin)->patch(route('users.update-password', $target), [
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_rejects_mismatch(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();
        $oldHash = $target->password;

        $response = $this->actingAs($admin)->patch(route('users.update-password', $target), [
            'password'              => 'NewSecurePass1!',
            'password_confirmation' => 'DifferentPass!',
        ]);

        $response->assertSessionHasErrors('password');
        $target->refresh();
        $this->assertEquals($oldHash, $target->password);
    }

    // ── destroy ───────────────────────────────────────────────────────────────

    public function test_admin_can_delete_other_user(): void
    {
        $admin  = $this->admin();
        $target = $this->regularUser();

        $response = $this->actingAs($admin)->delete(route('users.destroy', $target));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->delete(route('users.destroy', $admin));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
