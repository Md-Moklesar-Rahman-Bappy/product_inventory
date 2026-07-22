<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected Product $product;

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

        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);
    }

    protected function mockActivityLog(): void
    {
        $this->mock(\App\Http\Controllers\ActivityLogController::class, function ($mock) {
            $mock->shouldReceive('logAction')->andReturn(null);
        });
    }

    // === Read Tests ===

    public function test_admin_can_view_maintenance_list(): void
    {
        $response = $this->actingAs($this->admin)->get('/maintenance');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_maintenance_list(): void
    {
        $response = $this->actingAs($this->user)->get('/maintenance');

        $response->assertStatus(403);
    }

    public function test_any_authenticated_user_can_view_maintenance_show(): void
    {
        $maintenance = Maintenance::create([
            'product_id' => $this->product->id,
            'user_id' => $this->admin->id,
            'description' => 'Test maintenance',
            'performed_at' => now(),
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);

        $response = $this->actingAs($this->user)->get("/maintenance/{$maintenance->id}");

        $response->assertStatus(200);
    }

    public function test_admin_is_redirected_when_no_product_selected(): void
    {
        $response = $this->actingAs($this->admin)->get('/maintenance/create');

        $response->assertStatus(302);
    }

    // === Create Tests ===

    public function test_admin_can_create_maintenance(): void
    {
        $response = $this->actingAs($this->admin)->post('/maintenance', [
            'product_id' => $this->product->id,
            'description' => 'Test maintenance',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('maintenances', [
            'product_id' => $this->product->id,
            'description' => 'Test maintenance',
        ]);
    }

    public function test_maintenance_requires_product(): void
    {
        $response = $this->actingAs($this->admin)->post('/maintenance', [
            'product_id' => '',
            'description' => 'Test maintenance',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);

        $response->assertSessionHasErrors('product_id');
    }

    public function test_maintenance_requires_start_time(): void
    {
        $response = $this->actingAs($this->admin)->post('/maintenance', [
            'product_id' => $this->product->id,
            'description' => 'Test maintenance',
            'start_time' => '',
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);

        $response->assertSessionHasErrors('start_time');
    }

    public function test_maintenance_requires_end_time(): void
    {
        $response = $this->actingAs($this->admin)->post('/maintenance', [
            'product_id' => $this->product->id,
            'description' => 'Test maintenance',
            'start_time' => now()->toDateTimeString(),
            'end_time' => '',
        ]);

        $response->assertSessionHasErrors('end_time');
    }

    // === Delete Tests ===

    public function test_admin_can_delete_maintenance(): void
    {
        $maintenance = Maintenance::create([
            'product_id' => $this->product->id,
            'user_id' => $this->admin->id,
            'description' => 'Test maintenance',
            'performed_at' => now(),
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);

        $response = $this->actingAs($this->admin)->delete("/maintenance/{$maintenance->id}");

        $response->assertStatus(302);
    }

    // === Product Lookup Tests ===

    public function test_admin_can_get_product_by_serial(): void
    {
        $response = $this->actingAs($this->admin)->get("/maintenance/product/{$this->product->serial_no}");

        $response->assertStatus(200);
    }

    public function test_invalid_serial_returns_not_found(): void
    {
        $response = $this->actingAs($this->admin)->get('/maintenance/product/INVALID-SERIAL');

        $response->assertStatus(404);
    }
}