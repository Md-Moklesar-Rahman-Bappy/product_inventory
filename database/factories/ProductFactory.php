<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => fake()->bothify('Product-####'),
            'price' => fake()->randomFloat(2, 100, 10000),
            'category_id' => \App\Models\Category::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'model_id' => \App\Models\AssetModel::factory(),
            'serial_no' => fake()->unique()->numerify('SN-######'),
            'project_serial_no' => fake()->unique()->numerify('PSN-######'),
            'position' => fake()->optional()->sentence(2),
            'user_description' => fake()->optional()->paragraph(),
            'remarks' => fake()->optional()->paragraph(),
            'warranty_start' => now(),
            'warranty_end' => now()->addYear(),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'warranty_start' => now()->subYear()->subDay(),
            'warranty_end' => now()->subDay(),
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'warranty_start' => now(),
            'warranty_end' => now()->addYear(),
        ]);
    }

    public function noWarranty(): static
    {
        return $this->state(fn (array $attributes) => [
            'warranty_start' => null,
            'warranty_end' => null,
        ]);
    }
}