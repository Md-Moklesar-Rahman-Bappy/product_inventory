<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockActivityLog();

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

    public function test_admin_can_view_categories(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_categories(): void
    {
        $response = $this->actingAs($this->user)->get('/categories');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_category_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories/create');

        $response->assertStatus(200);
    }

    // === Create Tests ===

    public function test_admin_can_create_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/categories', [
            'category_name' => 'Test Category',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('categories', [
            'category_name' => 'Test Category',
        ]);
    }

    public function test_category_name_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/categories', [
            'category_name' => '',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('category_name');
    }

    public function test_category_name_must_be_unique(): void
    {
        Category::factory()->create(['category_name' => 'Duplicate']);

        $response = $this->actingAs($this->admin)->post('/categories', [
            'category_name' => 'Duplicate',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('category_name');
    }

    // === Update Tests ===

    public function test_admin_can_view_category_edit_form(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get("/categories/{$category->id}/edit");

        $response->assertStatus(200);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::factory()->create(['category_name' => 'Original']);

        $response = $this->actingAs($this->admin)->put("/categories/{$category->id}", [
            'category_name' => 'Updated',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'category_name' => 'Updated',
        ]);
    }

    // === Delete Tests ===

    public function test_admin_can_soft_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/categories/{$category->id}");

        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_admin_can_restore_category(): void
    {
        $category = Category::factory()->create();
        $category->delete();

        $response = $this->actingAs($this->admin)->post("/categories/{$category->id}/restore");

        $this->assertNotSoftDeleted('categories', [
            'id' => $category->id,
        ]);
    }

    // === Import/Export Tests ===

    public function test_admin_can_download_category_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories/sample');

        $response->assertStatus(200);
    }

    public function test_admin_can_export_categories(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories/export');

        $response->assertStatus(200);
    }
}