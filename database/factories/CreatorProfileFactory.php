<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreatorProfile>
 */
class CreatorProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bio' => fake()->optional()->paragraph(3),
            'specialties' => fake()->randomElements([
                'birthdays', 'anniversaries', 'holidays', 'graduations', 
                'weddings', 'baby_showers', 'corporate_events'
            ], fake()->numberBetween(1, 4)),
            'portfolio_url' => fake()->optional()->url(),
            'experience_years' => fake()->numberBetween(0, 10),
            'pricing_tier' => fake()->randomElement(['free', 'basic', 'premium', 'enterprise']),
            'rating' => fake()->randomFloat(2, 0, 5),
            'total_greetings_created' => fake()->numberBetween(0, 100),
            'verification_status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'verification_documents' => fake()->optional()->randomElements([
                'id_document.pdf', 'portfolio_sample.jpg', 'reference_letter.pdf'
            ]),
            'social_links' => [
                'instagram' => fake()->optional()->url(),
                'twitter' => fake()->optional()->url(),
                'linkedin' => fake()->optional()->url(),
            ],
            'availability_status' => fake()->boolean(80), // 80% available
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'approved',
            'rating' => fake()->randomFloat(2, 3.5, 5),
        ]);
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'pricing_tier' => 'premium',
            'verification_status' => 'approved',
            'experience_years' => fake()->numberBetween(3, 10)
        ]);
    }
}
