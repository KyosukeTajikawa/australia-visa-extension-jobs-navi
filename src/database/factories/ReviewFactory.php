<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_position' => fake()->realText(10),
            'hourly_wage' => fake()->dayOfMonth(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'work_rating' => fake()->numberBetween(1, 5),
            'salary_rating' => fake()->numberBetween(1, 5),
            'hour_rating' => fake()->numberBetween(1, 5),
            'relation_rating' => fake()->numberBetween(1, 5),
            'overall_rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->realText(100),
            'pay_type' => fake()->numberBetween(1, 2),
            'is_car_required' => fake()->numberBetween(1, 2),
            'user_id' => User::factory(),
            'farm_id' => Farm::factory(),
        ];
    }
}
