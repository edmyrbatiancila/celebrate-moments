<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['birthday', 'anniversary', 'holiday', 'graduation', 'wedding', 'custom'];
        $category = fake()->randomElement($categories);

        return [
            'name' => $this->getTemplateNameByCategory($category),
            'description' => fake()->paragraph(2),
            'category' => $category,
            'content_structure' => $this->generateContentStructure($category),
            'preview_image' => fake()->imageUrl(800, 600, 'celebration'),
            'is_premium' => fake()->boolean(30), // 30% premium templates
            'creator_id' => null, // Will be set by seeder for some templates
            'usage_count' => fake()->numberBetween(0, 100),
            'rating' => fake()->randomFloat(2, 3.5, 5.0)
        ];
    }

    private function getTemplateNameByCategory(string $category): string
    {
        $names = [
            'birthday' => ['Happy Birthday Celebration', 'Birthday Wishes Special', 'Another Year Older'],
            'anniversary' => ['Love Anniversary', 'Years Together', 'Milestone Celebration'],
            'holiday' => ['Holiday Greetings', 'Seasonal Joy', 'Festival Wishes'],
            'graduation' => ['Graduation Success', 'Academic Achievement', 'New Beginnings'],
            'wedding' => ['Wedding Bliss', 'Marriage Celebration', 'Love Union'],
            'custom' => ['Custom Creation', 'Personal Touch', 'Unique Design']
        ];
        
        return fake()->randomElement($names[$category] ?? $names['custom']);
    }

    private function generateContentStructure(string $category): array
    {
        return [
            'layout' => fake()->randomElement(['single-page', 'multi-slide', 'animated']),
            'components' => [
                'header' => ['title', 'subtitle', 'date'],
                'body' => ['message', 'images', 'video'],
                'footer' => ['signature', 'call-to-action']
            ],
            'styling' => [
                'theme' => $this->getThemeByCategory($category),
                'colors' => fake()->randomElements(['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'], 3),
                'fonts' => fake()->randomElement(['Arial', 'Roboto', 'Poppins', 'Montserrat'])
            ],
            'animations' => fake()->randomElements(['fadeIn', 'slideUp', 'bounceIn', 'zoomIn'], 2),
            'interactive_elements' => fake()->randomElements(['buttons', 'forms', 'galleries'], 1)
        ];
    }

    private function getThemeByCategory(string $category): string
    {
        $themes = [
            'birthday' => 'party',
            'anniversary' => 'romantic',
            'holiday' => 'festive',
            'graduation' => 'achievement',
            'wedding' => 'elegant',
            'custom' => 'modern'
        ];
        
        return $themes[$category] ?? 'modern';
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_premium' => true,
            'rating' => fake()->randomFloat(2, 4.0, 5.0),
            'usage_count' => fake()->numberBetween(50, 500)
        ]);
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_premium' => false,
            'creator_id' => null
        ]);
    }

    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => fake()->numberBetween(200, 1000),
            'rating' => fake()->randomFloat(2, 4.5, 5.0)
        ]);
    }
}
