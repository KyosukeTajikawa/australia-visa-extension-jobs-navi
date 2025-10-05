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
            'name' => fake()->company(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'street_address' => fake()->streetAddress(),
            'suburb' => fake()->streetName(),
            // NOTE: 本番の時に使用
            // 'state_id' => fake()->numberBetween(1, 8),
            // NOTE: テストの時はこちらを使用
            'state_id' => State::factory(),
            'postcode' => fake()->postcode2(),
            'postcode' => fake()->postcode2(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->realText(200),
            'created_user_id' => User::factory(),
        ];
    }
}
