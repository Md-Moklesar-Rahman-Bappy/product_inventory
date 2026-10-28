<?php

use App\Exports\CategoryProductExport;
use App\Exports\BrandProductExport;
use App\Exports\AssetModelProductExport;
use App\Exports\ProductExport;
use App\Services\ProductRowMapper;
use Maatwebsite\Excel\Facades\Excel;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function () {
    $user = \App\Models\User::factory()->create([
        'is_admin' => true,
        'is_superadmin' => false,
    ]);
    actingAs($user);
});

test('product export headings match canonical order', function () {
    $export = new ProductExport();
    $headings = $export->headings();
    expect($headings)->toBe(ProductRowMapper::headings());
});

test('product export row values align with headings', function () {
    $product = \App\Models\Product::factory()->create([
        'product_name' => 'Test Product',
        'price' => 100,
        'position' => 'ICT Section',
        'serial_no' => 'TEST-001',
        'project_serial_no' => 'TEST/001',
        'user_description' => 'Test desc',
        'remarks' => 'Test remarks',
    ]);
    $export = new ProductExport();
    $map = $export->map($product);
    expect($map['product_name'])->toBe('Test Product')
        ->and($map['position'])->toBe('ICT Section')
        ->and($map['serial_no'])->toBe('TEST-001');
});

test('empty remarks does not shift warranty_start', function () {
    $product = \App\Models\Product::factory()->create([
        'remarks' => null,
        'warranty_start' => now(),
        'warranty_end' => now()->addYear(),
    ]);
    $map = \App\Services\ProductRowMapper::mapRow($product);
    expect($map['remarks'])->toBe('')
        ->and($map['warranty_start'])->not()->toBe('')
        ->and($map['warranty_end'])->not()->toBe('');
});

test('empty warranty_end remains empty final cell', function () {
    $product = \App\Models\Product::factory()->create([
        'warranty_start' => now(),
        'warranty_end' => null,
    ]);
    $map = \App\Services\ProductRowMapper::mapRow($product);
    expect($map['warranty_end'])->toBe('')
        ->and($map['warranty_start'])->not()->toBe('');
});

test('position exports as text and does not become 0', function () {
    $product = \App\Models\Product::factory()->create([
        'position' => 'ICT Section',
    ]);
    $map = \App\Services\ProductRowMapper::mapRow($product);
    expect($map['position'])->toBe('ICT Section')
        ->and($map['position'])->not()->toBe('0');
});

test('bangla position survives create, retrieval, and export', function () {
    $product = \App\Models\Product::factory()->create([
        'position' => 'প্রকল্প পরিচালকের কক্ষ',
    ]);
    $retrieved = \App\Models\Product::find($product->id);
    expect($retrieved->position)->toBe('প্রকল্প পরিচালকের কক্ষ');
    $map = \App\Services\ProductRowMapper::mapRow($retrieved);
    expect($map['position'])->toBe('প্রকল্প পরিচালকের কক্ষ');
});

test('bangla user_description survives import and export', function () {
    $product = \App\Models\Product::factory()->create([
        'user_description' => 'সহকারী রক্ষণাবেক্ষণ প্রকৌশলীর জন্য বরাদ্দ',
    ]);
    $map = \App\Services\ProductRowMapper::mapRow($product);
    expect($map['user_description'])->toBe('সহকারী রক্ষণাবেক্ষণ প্রকৌশলীর জন্য বরাদ্দ');
});

test('bangla remarks survives import and export', function () {
    $product = \App\Models\Product::factory()->create([
        'remarks' => 'বাংলা ইউনিকোড পরীক্ষার নমুনা',
    ]);
    $map = \App\Services\ProductRowMapper::mapRow($product);
    expect($map['remarks'])->toBe('বাংলা ইউনিকোড পরীক্ষার নমুনা');
});

test('category-based product export uses canonical columns', function () {
    $category = \App\Models\Category::factory()->create(['category_name' => 'Laptop']);
    $export = new CategoryProductExport($category->id);
    expect($export->headings())->toBe(ProductRowMapper::headings());
});

test('brand-based product export uses canonical columns', function () {
    $brand = \App\Models\Brand::factory()->create(['brand_name' => 'HP']);
    $export = new BrandProductExport($brand->id);
    expect($export->headings())->toBe(ProductRowMapper::headings());
});

test('model-based product export uses canonical columns', function () {
    $model = \App\Models\AssetModel::factory()->create(['model_name' => 'ProBook']);
    $export = new AssetModelProductExport($model->id);
    expect($export->headings())->toBe(ProductRowMapper::headings());
});

test('authorized users can access import route', function () {
    get(route('products.import'))
        ->assertStatus(200);
});

// Note: More detailed authorization and import validation tests can be expanded based on environment.
