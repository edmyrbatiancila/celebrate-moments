<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $budgetRanges = [
            ['min' => 0, 'max' => 50],
            ['min' => 50, 'max' => 100],
            ['min' => 100, 'max' => 250],
            ['min' => 250, 'max' => 500],
            null // No budget
        ];

        return [
            'user_id' => User::factory(),
            'creator_id' => fake()->optional(0.3)->randomElement(User::where('is_creator', true)->pluck('id')->toArray()),
            'greeting_type' => fake()->randomElement(['video', 'audio', 'text', 'mixed']),
            'occasion' => fake()->randomElement(['birthday', 'anniversary', 'holiday', 'graduation', 'wedding', 'custom']),
            'budget_range' => fake()->randomElement($budgetRanges),
            'description' => fake()->optional(0.7)->paragraph(),
        ];
    }

    public function withBudget(): static
    {
        return $this->state(fn (array $attributes) => [
            'budget_range' => fake()->randomElement([
                ['min' => 50, 'max' => 100],
                ['min' => 100, 'max' => 250],
                ['min' => 250, 'max' => 500],
            ]),
        ]);
    }

    public function forSpecificCreator(): static
    {
        return $this->state(fn (array $attributes) => [
            'creator_id' => User::where('is_creator', true)->inRandomOrder()->first()->id,
        ]);
    }
}
