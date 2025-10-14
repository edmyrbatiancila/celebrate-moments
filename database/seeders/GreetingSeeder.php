<?php

namespace Database\Seeders;

use App\Models\Greeting;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = User::where('is_creator', true)->get();
        $celebrants = User::where('is_creator', false)->get();
        
        foreach ($creators as $creator) {
            // Create 2-5 greetings per creator
            $greetings = Greeting::factory(fake()->numberBetween(2, 5))
                ->create(['creator_id' => $creator->id]);
                
            foreach ($greetings as $greeting) {
                // Assign 1-3 random recipients to each greeting
                $recipients = $celebrants->random(fake()->numberBetween(1, 3));
                foreach ($recipients as $recipient) {
                    $greeting->recipients()->attach($recipient->id, [
                        'sent_at' => $greeting->status === 'sent' ? now() : null,
                        'delivered_at' => $greeting->status === 'delivered' ? now() : null,
                        'viewed_at' => $greeting->status === 'viewed' ? now() : null,
                    ]);
                }

                $availableMedia = Media::where('user_id', $greeting->creator_id)->get();
                if ($availableMedia->isNotEmpty()) {
                    $mediaToAttach = $availableMedia->random(min(fake()->numberBetween(1, 3), $availableMedia->count()));
                    
                    foreach ($mediaToAttach as $index => $media) {
                        $greeting->media()->attach($media->id, ['order' => $index + 1]);
                    }
                }
            }
        }
    }
}
