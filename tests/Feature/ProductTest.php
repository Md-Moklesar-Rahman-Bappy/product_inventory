<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
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

    public function test_admin_can_view_products_list(): void
    {
        $response = $this->actingAs($this->admin)->get('/products');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_products_list(): void
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(403);
    }

    public function test_product_search_returns_results(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $product = Product::factory()->create([
            'serial_no' => 'SEARCH-TEST-001',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/products?search=SEARCH');

        $response->assertStatus(200);
        $response->assertSee('SEARCH-TEST-001');
    }

    public function test_product_warranty_filter_works(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $expiredProduct = Product::factory()->create([
            'warranty_end' => now()->subDay(),
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/products?warranty_status=expired');

        $response->assertStatus(200);
    }
}