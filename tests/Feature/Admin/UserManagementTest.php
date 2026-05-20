<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->adminUser = User::factory()->create([
            'username' => 'admin',
        ]);

        // Create a regular user
        $this->regularUser = User::factory()->create([
            'username' => 'syamil',
        ]);
    }

    public function test_guest_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.users.index'))->assertRedirect(route('login'));
        $this->get(route('admin.users.create'))->assertRedirect(route('login'));
        $this->get(route('admin.users.edit', $this->regularUser->id))->assertRedirect(route('login'));
        $this->post(route('admin.users.store'), [])->assertRedirect(route('login'));
        $this->put(route('admin.users.update', $this->regularUser->id), [])->assertRedirect(route('login'));
        $this->delete(route('admin.users.destroy', $this->regularUser->id))->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_routes(): void
    {
        $this->actingAs($this->regularUser);

        $this->get(route('admin.users.index'))->assertStatus(403);
        $this->get(route('admin.users.create'))->assertStatus(403);
        $this->get(route('admin.users.edit', $this->regularUser->id))->assertStatus(403);
        $this->post(route('admin.users.store'), [])->assertStatus(403);
        $this->put(route('admin.users.update', $this->regularUser->id), [])->assertStatus(403);
        $this->delete(route('admin.users.destroy', $this->regularUser->id))->assertStatus(403);
    }

    public function test_admin_user_can_access_index_and_create(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertSee('Manage Users');
        $response->assertSee('admin');
        $response->assertSee('syamil');

        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New User');
    }

    public function test_admin_user_can_create_a_new_user(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'New User',
            'username' => 'newuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User successfully created.');

        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'name' => 'New User',
        ]);
    }

    public function test_admin_user_can_edit_and_update_a_user(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.edit', $this->regularUser->id));
        $response->assertStatus(200);
        $response->assertSee('Edit User');
        $response->assertSee('syamil');

        // Update name and username
        $response = $this->put(route('admin.users.update', $this->regularUser->id), [
            'name' => 'Syamil Updated',
            'username' => 'syamil_new',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User successfully updated.');

        $this->assertDatabaseHas('users', [
            'id' => $this->regularUser->id,
            'name' => 'Syamil Updated',
            'username' => 'syamil_new',
        ]);

        // Try updating password
        $response = $this->put(route('admin.users.update', $this->regularUser->id), [
            'name' => 'Syamil Updated',
            'username' => 'syamil_new',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User successfully updated.');
    }

    public function test_admin_user_can_delete_other_users(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('admin.users.destroy', $this->regularUser->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User successfully deleted.');

        $this->assertDatabaseMissing('users', [
            'id' => $this->regularUser->id,
        ]);
    }

    public function test_admin_user_cannot_delete_themselves(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('admin.users.destroy', $this->adminUser->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Cannot delete the admin account.');

        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
        ]);
    }
}
