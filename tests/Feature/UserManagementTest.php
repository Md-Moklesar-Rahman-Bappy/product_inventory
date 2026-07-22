<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockActivityLog();

        $this->superadmin = User::factory()->create([
            'permission' => 0,
            'status' => 'active',
        ]);

        $this->admin = User::factory()->create([
            'permission' => 1,
            'status' => 'active',
        ]);

        $this->user = User::factory()->create([
            'permission' => 2,
            'status' => 'active',
        ]);
    }

    protected function mockActivityLog(): void
    {
        $this->mock(\App\Http\Controllers\ActivityLogController::class, function ($mock) {
            $mock->shouldReceive('logAction')->andReturn(null);
        });
    }

    // === Read Tests ===

    public function test_admin_can_view_users_list(): void
    {
        $response = $this->actingAs($this->admin)->get('/users');

        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_view_users_list(): void
    {
        $response = $this->actingAs($this->user)->get('/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_user_profile(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/users/{$targetUser->id}");

        $response->assertStatus(200);
    }

    // === Update Tests ===

    public function test_admin_can_view_user_edit_form(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/users/{$targetUser->id}/edit");

        $response->assertStatus(200);
    }

    public function test_admin_can_update_user(): void
    {
        $targetUser = User::factory()->create(['name' => 'Original']);

        $response = $this->actingAs($this->admin)->put("/users/{$targetUser->id}", [
            'name' => 'Updated',
            'email' => $targetUser->email,
            'permission' => $targetUser->permission,
            'status' => $targetUser->status,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Updated',
        ]);
    }

    public function test_user_can_update_own_profile(): void
    {
        $response = $this->actingAs($this->user)->post('/profile', [
            'name' => 'Updated Name',
            'mobile' => '1234567890',
            'designation' => 'Tester',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
        ]);
    }

    // === Delete Tests ===

    public function test_admin_can_soft_delete_user(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/users/{$targetUser->id}");

        $this->assertSoftDeleted('users', [
            'id' => $targetUser->id,
        ]);
    }

    public function test_admin_can_restore_user(): void
    {
        $targetUser = User::factory()->create([
            'email' => 'restore-test@example.com',
        ]);
        $targetUser->delete();

        $response = $this->actingAs($this->superadmin)->post("/users/{$targetUser->id}/restore");

        $this->assertNotSoftDeleted('users', [
            'id' => $targetUser->id,
        ]);
    }

    // === Toggle Status Tests ===

    public function test_superadmin_can_toggle_user_status(): void
    {
        $targetUser = User::factory()->create(['status' => 'active']);

        $response = $this->actingAs($this->superadmin)->patch("/users/{$targetUser->id}/toggle-status");

        $response->assertStatus(302);
    }

    public function test_admin_cannot_toggle_user_status(): void
    {
        $targetUser = User::factory()->create(['status' => 'active']);

        $response = $this->actingAs($this->admin)->patch("/users/{$targetUser->id}/toggle-status");

        $response->assertStatus(403);
    }
}