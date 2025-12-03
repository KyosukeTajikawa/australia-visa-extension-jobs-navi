<?php

namespace Database\Factories;

use App\Models\State;
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
            'name' => fake()->unique()->company(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'street_address' => fake()->streetAddress(),
            'suburb' => fake()->streetName(),
            'state_id' => state::factory(),
            'postcode' => (string) fake()->numberBetween(2000, 9999),
            'description' => fake()->realText(200),
            'created_user_id' => User::factory(),
        ];
    }
}
