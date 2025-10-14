<?php

namespace Database\Factories;

use App\Models\Greeting;
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
        $rating = fake()->numberBetween(1, 5);
    
        return [
            'reviewer_id' => User::factory(),
            'reviewee_id' => User::factory(),
            'greeting_id' => fake()->optional(0.7)->randomElement(Greeting::pluck('id')->toArray()),
            'rating' => $rating,
            'comment' => $rating >= 4 ? fake()->paragraph() : fake()->optional(0.7)->paragraph(),
            'is_anonymous' => fake()->boolean(20), // 20% chance of anonymous
        ];
    }

    public function positive(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
            'comment' => fake()->paragraph(),
        ]);
    }

    public function negative(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
            'comment' => fake()->optional(0.5)->paragraph(),
        ]);
    }

    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_anonymous' => true,
        ]);
    }
}
