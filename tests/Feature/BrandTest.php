<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
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

    public function test_admin_can_view_brands(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_brands(): void
    {
        $response = $this->actingAs($this->user)->get('/brands');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_brand_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands/create');

        $response->assertStatus(200);
    }

    // === Create Tests ===

    public function test_admin_can_create_brand(): void
    {
        $response = $this->actingAs($this->admin)->post('/brands', [
            'brand_name' => 'Test Brand',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('brands', [
            'brand_name' => 'Test Brand',
        ]);
    }

    public function test_brand_name_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/brands', [
            'brand_name' => '',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('brand_name');
    }

    public function test_brand_name_must_be_unique(): void
    {
        Brand::factory()->create(['brand_name' => 'Duplicate']);

        $response = $this->actingAs($this->admin)->post('/brands', [
            'brand_name' => 'Duplicate',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('brand_name');
    }

    // === Update Tests ===

    public function test_admin_can_view_brand_edit_form(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)->get("/brands/{$brand->id}/edit");

        $response->assertStatus(200);
    }

    public function test_admin_can_update_brand(): void
    {
        $brand = Brand::factory()->create(['brand_name' => 'Original']);

        $response = $this->actingAs($this->admin)->put("/brands/{$brand->id}", [
            'brand_name' => 'Updated',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'brand_name' => 'Updated',
        ]);
    }

    // === Delete Tests ===

    public function test_admin_can_soft_delete_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/brands/{$brand->id}");

        $this->assertSoftDeleted('brands', [
            'id' => $brand->id,
        ]);
    }

    public function test_admin_can_restore_brand(): void
    {
        $brand = Brand::factory()->create();
        $brand->delete();

        $response = $this->actingAs($this->admin)->post("/brands/{$brand->id}/restore");

        $this->assertNotSoftDeleted('brands', [
            'id' => $brand->id,
        ]);
    }

    // === Import/Export Tests ===

    public function test_admin_can_download_brand_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands/sample');

        $response->assertStatus(200);
    }

    public function test_admin_can_export_brands(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands/export');

        $response->assertStatus(200);
    }
}