<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating collaborations...');
    
        $greetings = \App\Models\Greeting::all();
        $users = \App\Models\User::all();
        
        // Only create collaborations for 30% of greetings (team projects)
        $collaborativeGreetings = $greetings->random($greetings->count() * 0.3);
        
        foreach ($collaborativeGreetings as $greeting) {
            // Each collaborative greeting has 1-3 collaborators
            $collaboratorCount = fake()->numberBetween(1, 3);
            
            // Exclude the greeting creator from potential collaborators
            $potentialCollaborators = $users->where('id', '!=', $greeting->creator_id);
            $selectedCollaborators = $potentialCollaborators->random($collaboratorCount);
            
            foreach ($selectedCollaborators as $collaborator) {
                \App\Models\Collaboration::create([
                    'greeting_id' => $greeting->id,
                    'collaborator_id' => $collaborator->id,
                    'role' => fake()->randomElement(['editor', 'contributor', 'viewer']),
                    'status' => fake()->randomElement(['invited', 'accepted', 'declined']),
                ]);
            }
        }
        
        $this->command->info('Collaborations created successfully!');
    }
}
