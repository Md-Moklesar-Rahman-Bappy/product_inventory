# Testing Guide

This document covers the testing setup, configuration, and best practices for Product Inventory.

## Overview

Product Inventory uses **PestPHP 3.8** as its testing framework, built on top of **PHPUnit 11.5**. Tests run against an in-memory SQLite database by default (configured in `phpunit.xml`), so no external database is needed.

## Setup

### Prerequisites

- PHP 8.2+ with all required extensions
- Composer dependencies installed (`composer install`)
- No additional setup required — the testing database is configured in `phpunit.xml`

### Test Configuration

The `phpunit.xml` file defines the test environment:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="APP_MAINTENANCE_DRIVER" value="file"/>
    <env name="BCRYPT_ROUNDS" value="4"/>
    <env name="CACHE_STORE" value="array"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="MAIL_MAILER" value="array"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="PULSE_ENABLED" value="false"/>
    <env name="TELESCOPE_ENABLED" value="false"/>
    <env name="NIGHTWATCH_ENABLED" value="false"/>
</php>
```

Key settings:
- **In-memory SQLite** — fast, no persistence between test runs
- **BCrypt rounds reduced to 4** — faster password hashing during tests
- **Array cache/session/mail** — no file or database side effects
- **Sync queue** — jobs execute immediately
- **Monitoring disabled** — Pulse, Telescope, and Nightwatch are off

## Running Tests

### Run All Tests

```bash
php artisan test
```

Or directly with Pest:

```bash
./vendor/bin/pest
```

### Run a Specific Test File

```bash
php artisan test tests/Feature/ProductTest.php
```

### Run a Specific Test

```bash
./vendor/bin/pest --filter="can_create_product"
```

### Run by Test Suite

```bash
# Unit tests only
./vendor/bin/pest tests/Unit

# Feature tests only
./vendor/bin/pest tests/Feature
```

### Run with Coverage

```bash
./vendor/bin/pest --coverage
```

Requires Xdebug or PCOV extension.

### Verbose Output

```bash
./vendor/bin/pest -v
```

## Test Directory Structure

```
tests/
├── Pest.php              # Pest configuration, custom expectations, helpers
├── TestCase.php          # Base test case (extends Illuminate\Foundation\Testing\TestCase)
├── Feature/              # Integration tests (HTTP requests, database, auth)
│   └── (test files)
└── Unit/                 # Unit tests (model methods, helpers, pure logic)
    └── (test files)
```

## Feature vs Unit Tests

### Feature Tests

Feature tests verify the application's behavior from the outside — simulating HTTP requests and checking responses, database state, and authentication.

**Place in:** `tests/Feature/`

**Examples:**
- HTTP route responses (200, 302, 403, 404)
- Authentication flows (login, logout, register)
- Authorization checks (role-based access)
- Form validation (valid and invalid submissions)
- Database operations (create, update, delete, restore)
- File uploads (profile photos)
- Excel import/export

### Unit Tests

Unit tests verify isolated pieces of logic — model methods, accessors, mutators, scopes, and helper functions.

**Place in:** `tests/Unit/`

**Examples:**
- Model accessor return values
- Mutator transformations
- Warranty status calculations
- Urgency level logic
- String helper functions
- Role check methods

## Writing Tests

### Pest Syntax (Preferred)

```php
<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('retrieves all active products', function () {
    // Arrange
    $category = Category::factory()->create();
    Product::factory()->count(3)->create([
        'category_id' => $category->id,
    ]);

    // Act
    $response = $this->get('/products');

    // Assert
    $response->assertStatus(200);
    $response->assertSee($category->category_name);
});

it('prevents unauthenticated access to products', function () {
    $response = $this->get('/products');
    $response->assertRedirect('/login');
});

it('calculates warranty status correctly', function () {
    $product = Product::factory()->create([
        'warranty_end' => now()->addDays(30),
    ]);

    expect($product->warranty_status)->toBe('active');

    $expiredProduct = Product::factory()->create([
        'warranty_end' => now()->subDays(5),
    ]);

    expect($expiredProduct->warranty_status)->toBe('expired');
});
```

### PHPUnit Syntax

```php
<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_products(): void
    {
        $user = User::factory()->create([
            'permission' => 1,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_is_redirected(): void
    {
        $response = $this->get('/products');

        $response->assertRedirect('/login');
    }
}
```

### Common Test Patterns

#### Authentication

```php
// Create and authenticate a user
$user = User::factory()->create([
    'permission' => 1,
    'status' => 'active',
    'email_verified_at' => now(),
]);
$this->actingAs($user);
```

#### Database Factories

```php
// Using model factories (if defined)
$product = Product::factory()->create([
    'category_id' => $category->id,
    'warranty_end' => now()->addYear(),
]);
```

#### Form Submissions

```php
$response = $this->post('/products', [
    'product_name' => 'Test Product',
    'price' => 100.00,
    'category_id' => $category->id,
    'brand_id' => $brand->id,
    'serial_no' => 'SN-001',
]);

$response->assertRedirect();
$this->assertDatabaseHas('products', [
    'product_name' => 'Test Product',
]);
```

#### Testing Soft Deletes

```php
// Soft delete
$product->delete();
$this->assertSoftDeleted('products', ['id' => $product->id]);

// Restore
$this->post("/products/{$product->id}/restore");
$this->assertNotSoftDeleted('products', ['id' => $product->id]);
```

#### Testing File Uploads

```php
$response = $this->actingAs($user)->post('/users/' . $user->id, [
    'profile_photo' => UploadedFile::fake()->image('photo.jpg', 200, 200),
]);

$response->assertRedirect();
Storage::disk('public')->assertExists('profile-photos/' . basename($user->profile_photo_path));
```

## Best Practices

1. **Use `RefreshDatabase`** — Always use this trait in tests that touch the database to ensure a clean state
2. **Arrange-Act-Assert** — Structure tests clearly with the AAA pattern
3. **One assertion per concept** — Each test should verify one behavior
4. **Descriptive names** — Test names should explain what is being tested and the expected outcome
5. **Use factories** — Create test data via factories, not raw `DB::table()` inserts
6. **Test edge cases** — Include tests for invalid input, missing data, and boundary conditions
7. **Isolate tests** — Tests should not depend on each other or on database state from other tests
8. **Mock external services** — Mock the license server HTTP calls in tests:
   ```php
   Http::fake([
       config('LICENSE_SERVER_URL') => Http::response(['valid' => true], 200),
   ]);
   ```

## CI Integration

Add to your CI pipeline (GitHub Actions, GitLab CI, etc.):

```yaml
- name: Run Tests
  run: ./vendor/bin/pest
```

Tests will automatically use the in-memory SQLite database configured in `phpunit.xml`.
