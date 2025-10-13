<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating media library...');
        
        $creators = User::where('is_creator', true)->get();
        $celebrants = User::where('is_creator', false)->get();
        $allUsers = $creators->merge($celebrants);

        // Create media for each user
        foreach ($allUsers as $user) {
            // Each user gets 3-8 media files
            $mediaCount = fake()->numberBetween(3, 8);
            
            Media::factory($mediaCount)
                ->create(['user_id' => $user->id]);
                
            // Creators get additional media (they create more content)
            if ($user->is_creator) {
                Media::factory(fake()->numberBetween(5, 15))
                    ->create(['user_id' => $user->id]);
            }
        }

        // Create some specific media types for variety
        Media::factory(10)->image()->create();
        Media::factory(5)->video()->create();
        Media::factory(8)->audio()->create();
        Media::factory(3)->large()->create();
        
        $this->command->info('Media library created successfully!');
    }
}
