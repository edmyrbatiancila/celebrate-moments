<?php

namespace Database\Seeders;

use App\Models\Greeting;
use App\Models\GreetingAnalytics;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreetingAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $greetings = Greeting::all();

        if ($greetings->isEmpty()) {
            $this->command->warn('No greetings found. Please run GreetingSeeder first.');
            return;
        }

        $this->command->info('Creating analytics for ' . $greetings->count() . ' greetings...');

        foreach ($greetings as $greeting) {
            // Skip if analytics already exist
            if ($greeting->analytics) {
                continue;
            }
            
            // Determine engagement level based on greeting status
            $analyticsData = $this->getAnalyticsDataByStatus($greeting->status);
            
            // Create analytics record
            GreetingAnalytics::create([
                'greeting_id' => $greeting->id,
                'views_count' => $analyticsData['views_count'],
                'shares_count' => $analyticsData['shares_count'],
                'likes_count' => $analyticsData['likes_count'],
                'engagement_data' => $analyticsData['engagement_data']
            ]);
        }

        $this->command->info('Analytics created successfully.');
    }

    /**
     * Get analytics data based on greeting status
     */
    private function getAnalyticsDataByStatus(string $status): array
    {
        switch ($status) {
            case 'draft':
                return [
                    'views_count' => 0,
                    'shares_count' => 0,
                    'likes_count' => 0,
                    'engagement_data' => []
                ];

            case 'scheduled':
                return [
                    'views_count' => 0,
                    'shares_count' => 0,
                    'likes_count' => 0,
                    'engagement_data' => [
                        'scheduled_for' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d H:i:s')
                    ]
                ];

            case 'sent':
                return [
                    'views_count' => fake()->numberBetween(1, 50),
                    'shares_count' => fake()->numberBetween(0, 5),
                    'likes_count' => fake()->numberBetween(0, 10),
                    'engagement_data' => $this->generateEngagementData()
                ];

            case 'delivered':
                return [
                    'views_count' => fake()->numberBetween(10, 100),
                    'shares_count' => fake()->numberBetween(1, 15),
                    'likes_count' => fake()->numberBetween(2, 25),
                    'engagement_data' => $this->generateEngagementData()
                ];
            
            case 'viewed':
                return [
                    'views_count' => fake()->numberBetween(50, 500),
                    'shares_count' => fake()->numberBetween(5, 50),
                    'likes_count' => fake()->numberBetween(10, 100),
                    'engagement_data' => $this->generateEngagementData()
                ];

            default:
                return [
                    'views_count' => fake()->numberBetween(0, 100),
                    'shares_count' => fake()->numberBetween(0, 10),
                    'likes_count' => fake()->numberBetween(0, 20),
                    'engagement_data' => $this->generateEngagementData()
                ];
        }
    }

    /**
     * Generate realistic engagement data
     */
    private function generateEngagementData(): array
    {
        return [
            'peak_viewing_time' => fake()->time('H:i:s'),
            'average_watch_duration' => fake()->numberBetween(15, 180),
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
            ],
            'user_feedback' => [
                'emoji_reactions' => fake()->randomElements(['❤️', '👏', '🎉', '😊', '🔥'], fake()->numberBetween(0, 3)),
                'favorite_moments' => fake()->randomElements(['intro', 'message', 'outro', 'animation'], fake()->numberBetween(0, 2))
            ]
        ];
    }
}
