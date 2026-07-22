<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetModel>
 */
class AssetModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'model_name' => fake()->unique()->bothify('Model-####'),
            'status' => 'active',
        ];
    }
}