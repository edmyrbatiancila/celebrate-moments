<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collaboration>
 */
class CollaborationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'greeting_id' => \App\Models\Greeting::factory(),
            'collaborator_id' => \App\Models\User::factory(),
            'role' => fake()->randomElement(['editor', 'contributor', 'viewer']),
            'status' => fake()->randomElement(['invited', 'accepted', 'declined']),
        ];
    }

    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'editor',
            'status' => fake()->randomElement(['accepted', 'invited']),
        ]);
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
        ]);
    }

    public function invited(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'invited',
        ]);
    }
}
