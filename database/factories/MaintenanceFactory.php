<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maintenance>
 */
class MaintenanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'description' => 'Test maintenance description',
            'performed_at' => now(),
            'start_time' => now(),
            'end_time' => now()->addHour(),
            'user_id' => \App\Models\User::factory(),
        ];
    }

    public function repair(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => 'Repair',
        ]);
    }

    public function upgrade(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => 'Upgrade',
        ]);
    }

    public function inspection(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => 'Inspection',
        ]);
    }
}