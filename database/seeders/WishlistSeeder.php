<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating wishlists...');
    
        $celebrants = User::where('is_creator', false)->get();
        $creators = User::where('is_creator', true)->get();
        
        foreach ($celebrants as $celebrant) {
            // Each celebrant has 1-3 wishlist items
            $wishlistCount = fake()->numberBetween(1, 3);
            
            for ($i = 0; $i < $wishlistCount; $i++) {
                Wishlist::create([
                    'user_id' => $celebrant->id,
                    'creator_id' => fake()->optional(0.4)->randomElement($creators->pluck('id')->toArray()),
                    'greeting_type' => fake()->randomElement(['video', 'audio', 'text', 'mixed']),
                    'occasion' => fake()->randomElement(['birthday', 'anniversary', 'holiday', 'graduation']),
                    'budget_range' => fake()->optional(0.7)->randomElement([
                        ['min' => 25, 'max' => 75],
                        ['min' => 75, 'max' => 150],
                        ['min' => 150, 'max' => 300],
                    ]),
                    'description' => fake()->optional(0.8)->paragraph(),
                ]);
            }
        }
        
        $this->command->info('Wishlists created successfully!');
    }
}
