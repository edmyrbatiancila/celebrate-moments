<?php

namespace Database\Seeders;

use App\Models\Greeting;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating reviews...');
    
        $creators = User::where('is_creator', true)->get();
        $celebrants = User::where('is_creator', false)->get();
        $greetings = Greeting::all();
        
        foreach ($creators as $creator) {
            // Each creator gets 2-8 reviews
            $reviewCount = fake()->numberBetween(2, 8);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $reviewer = $celebrants->random();
                $greeting = $greetings->where('creator_id', $creator->id)->random();
                
                Review::create([
                    'reviewer_id' => $reviewer->id,
                    'reviewee_id' => $creator->id,
                    'greeting_id' => $greeting ? $greeting->id : null,
                    'rating' => fake()->numberBetween(1, 5),
                    'comment' => fake()->optional(0.8)->paragraph(),
                    'is_anonymous' => fake()->boolean(25),
                ]);
            }
        }
        
        $this->command->info('Reviews created successfully!');
    }
}
