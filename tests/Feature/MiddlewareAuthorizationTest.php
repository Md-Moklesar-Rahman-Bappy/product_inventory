<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $admin;
    protected User $user;
    protected Category $category;

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

        $this->category = Category::factory()->create();
    }

    protected function mockActivityLog(): void
    {
        $this->mock(\App\Http\Controllers\ActivityLogController::class, function ($mock) {
            $mock->shouldReceive('logAction')->andReturn(null);
        });
    }

    // === Test isAdmin middleware ===

    public function test_superadmin_can_access_admin_routes(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_routes(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_access_admin_routes(): void
    {
        $response = $this->actingAs($this->user)->get('/categories');

        $response->assertStatus(403);
    }

    // === Test isSuperadmin middleware ===

    public function test_superadmin_can_access_settings(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/settings');

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/settings');

        $response->assertStatus(403);
    }

    public function test_regular_user_cannot_access_settings(): void
    {
        $response = $this->actingAs($this->user)->get('/settings');

        $response->assertStatus(403);
    }

    // === Test force delete (superadmin only) ===

    public function test_superadmin_can_force_delete_category(): void
    {
        $response = $this->actingAs($this->superadmin)->delete("/categories/{$this->category->id}/force-delete");

        $response->assertStatus(302);
    }

    public function test_admin_cannot_force_delete_category(): void
    {
        $response = $this->actingAs($this->admin)->delete("/categories/{$this->category->id}/force-delete");

        $response->assertStatus(403);
    }

    // === Test toggle user status (superadmin only) ===

    public function test_superadmin_can_toggle_user_status(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->superadmin)->patch("/users/{$targetUser->id}/toggle-status");

        $response->assertStatus(302);
    }

    public function test_admin_cannot_toggle_user_status(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->patch("/users/{$targetUser->id}/toggle-status");

        $response->assertStatus(403);
    }
}