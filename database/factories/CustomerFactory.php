<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $rfc = bin2hex(random_bytes(10));
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber,
            'rfc' => $rfc,
            'address' => $this->faker->address
        ];
    }
}
