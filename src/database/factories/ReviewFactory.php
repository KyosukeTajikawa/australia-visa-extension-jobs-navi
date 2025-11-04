<?php

namespace Database\Factories;

use App\Models\ApplicationMethod;
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
            'pay_type' => fake()->numberBetween(1, 2),
            'is_car_required' => fake()->numberBetween(1, 2),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'application_method_id' => ApplicationMethod::factory(),
            'farm_rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->realText(100),
            'user_id' => User::factory(),
            'farm_id' => Farm::factory(),
        ];
    }
}
