<?php

namespace Database\Factories;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Greeting>
 */
class GreetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'greeting_type' => fake()->randomElement(['video', 'audio', 'text', 'mixed']),
            'occasion_type' => fake()->randomElement(['birthday', 'anniversary', 'holiday', 'graduation', 'custom']),
            'content_type' => fake()->randomElement(['personal', 'template_based', 'ai_generated']),
            'content_data' => [
                'message' => fake()->paragraph(),
                'background_color' => fake()->hexColor(),
                'font_style' => fake()->randomElement(['Arial', 'Times', 'Helvetica']),
            ],
            'template_id' => fake()->optional(0.4)->randomElement(Template::pluck('id')->toArray()),
            'theme_settings' => [
                'theme' => fake()->randomElement(['birthday', 'elegant', 'fun', 'formal']),
                'color_scheme' => fake()->randomElement(['blue', 'pink', 'green', 'purple']),
            ],
            'is_scheduled' => fake()->boolean(30),
            'scheduled_at' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['draft', 'scheduled', 'sent', 'delivered', 'viewed']),
            'is_collaborative' => fake()->boolean(20),
        ];
    }
}
