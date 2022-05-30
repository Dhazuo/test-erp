<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lastName,
            'price' => $this->faker->randomFloat(2, 10, 2000),
            'original_stock' => $this->faker->numberBetween(0, 5000),
            'actual_stock' => $this->faker->numberBetween(0, 5000),
        ];
    }
}
