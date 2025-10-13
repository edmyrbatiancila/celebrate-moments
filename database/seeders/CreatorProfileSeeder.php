<?php

namespace Database\Seeders;

use App\Models\CreatorProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreatorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = User::where('is_creator', true)->get();

        foreach ($creators as $creator) {
            // Only create profile if it doens't exist
            if (!$creator->creatorProfile) {
                CreatorProfile::create([
                    'user_id' => $creator->id,
                    'bio' => fake()->paragraph(2),
                    'specialties' => ['birthdays', 'anniversaries'],
                    'verification_status' => $creator->is_verified_creator ? 'approved' : 'pending',
                    'rating' => $creator->is_verified_creator ? fake()->randomFloat(2, 4, 5) : 0
                ]);
            }
        }
    }
}
