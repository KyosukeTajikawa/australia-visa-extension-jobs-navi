<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'street_address' => fake()->streetAddress(),
            'suburb' => fake()->streetName(),
            'state_id' => fake()->numberBetween(1, 8),
            'postcode' => fake()->postcode2(),
            'description' => fake()->realText(200),
            'created_user_id' => User::factory(),
        ];
    }
}
