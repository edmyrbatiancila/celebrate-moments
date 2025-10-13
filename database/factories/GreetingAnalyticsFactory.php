<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GreetingAnalytics>
 */
class GreetingAnalyticsFactory extends Factory
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
            'views_count' => fake()->numberBetween(0, 500),
            'shares_count' => fake()->numberBetween(0, 50),
            'likes_count' => fake()->numberBetween(0, 100),
            'engagement_data' => [
                'peak_viewing_time' => fake()->time('H:i:s'),
                'average_watch_duration' => fake()->numberBetween(15, 180), // seconds
                'completion_rate' => fake()->randomFloat(2, 0.1, 1.0),
                'device_types' => fake()->randomElements(['mobile', 'desktop', 'tablet'], fake()->numberBetween(1, 3)),
                'referrer_sources' => fake()->randomElements(['direct', 'email', 'social_media', 'website'], fake()->numberBetween(1, 2)),
                'geographic_data' => [
                    'country' => fake()->country(),
                    'city' => fake()->city(),
                    'timezone' => fake()->timezone()
                ],
                'interaction_timestamps' => [
                    'first_view' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d H:i:s'),
                    'last_interaction' => fake()->dateTimeBetween('-7 days', 'now')->format('Y-m-d H:i:s')
                ]
            ]
        ];
    }

    /**
     * Create analytics for popular greetings
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(100, 1000),
            'shares_count' => fake()->numberBetween(20, 100),
            'likes_count' => fake()->numberBetween(50, 200),
        ]);
    }

    /**
     * Create analytics for viral greetings
     */
    public function viral(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(500, 2000),
            'shares_count' => fake()->numberBetween(100, 500),
            'likes_count' => fake()->numberBetween(200, 800),
        ]);
    }

    /**
     * Create analytics with minimal engagement
     */
    public function lowEngagement(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(0, 10),
            'shares_count' => fake()->numberBetween(0, 2),
            'likes_count' => fake()->numberBetween(0, 5),
        ]);
    }
}
