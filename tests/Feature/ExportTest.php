<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockActivityLog();

        $this->admin = User::factory()->create([
            'permission' => 1,
            'status' => 'active',
        ]);
    }

    protected function mockActivityLog(): void
    {
        $this->mock(\App\Http\Controllers\ActivityLogController::class, function ($mock) {
            $mock->shouldReceive('logAction')->andReturn(null);
        });
    }

    // === Product Export Tests ===

    public function test_admin_can_export_products_excel(): void
    {
        $response = $this->actingAs($this->admin)->get('/products/export/excel');

        $response->assertStatus(200)
            ->assertHeader('content-disposition');
    }

    public function test_admin_can_export_products_category_wise(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/products/export/category-wise');

        $response->assertStatus(200);
    }

    public function test_admin_can_export_products_brand_wise(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)->get("/products/export/brand-wise/{$brand->id}");

        $response->assertStatus(200);
    }

    public function test_admin_can_get_product_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/products/sample');

        $response->assertStatus(200);
    }

    // === Category Export Tests ===

    public function test_admin_can_export_categories(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories/export');

        $response->assertStatus(200);
    }

    public function test_admin_can_get_category_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/categories/sample');

        $response->assertStatus(200);
    }

    public function test_admin_can_export_category_products(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get("/category/{$category->id}/products/export");

        $response->assertStatus(200);
    }

    // === Brand Export Tests ===

    public function test_admin_can_export_brands(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands/export');

        $response->assertStatus(200);
    }

    public function test_admin_can_get_brand_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/brands/sample');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_brand_products(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)->get("/brands/{$brand->id}/products");

        $response->assertStatus(200);
    }

    // === Model Export Tests ===

    public function test_admin_can_export_models(): void
    {
        $response = $this->actingAs($this->admin)->get('/models/export');

        $response->assertStatus(200);
    }

    public function test_admin_can_get_model_sample(): void
    {
        $response = $this->actingAs($this->admin)->get('/models/sample');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_model_products(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response = $this->actingAs($this->admin)->get("/models/{$product->model_id}/products");

        $response->assertStatus(200);
    }
}