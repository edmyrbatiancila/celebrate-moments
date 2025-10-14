<?php

namespace Database\Seeders;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating user connections...');
    
        $users = User::all();
        $connections = collect();
        
        foreach ($users as $user) {
            // Each user connects with 2-5 other users
            $connectionsCount = fake()->numberBetween(2, 5);
            $potentialConnections = $users->where('id', '!=', $user->id)->random($connectionsCount);
            
            foreach ($potentialConnections as $connection) {
                // Avoid duplicate connections
                $existingConnection = $connections->first(function ($conn) use ($user, $connection) {
                    return ($conn['requester_id'] === $user->id && $conn['receiver_id'] === $connection->id) ||
                        ($conn['requester_id'] === $connection->id && $conn['receiver_id'] === $user->id);
                });
                
                if (!$existingConnection) {
                    $connectionData = [
                        'requester_id' => $user->id,
                        'receiver_id' => $connection->id,
                        'status' => fake()->randomElement(['pending', 'accepted', 'declined']),
                    ];
                    
                    if ($connectionData['status'] === 'accepted') {
                        $connectionData['connected_at'] = fake()->dateTimeBetween('-3 months', 'now');
                    }
                    
                    $connections->push($connectionData);
                }
            }
        }
        
        // Insert all connections
        foreach ($connections->take(50) as $connectionData) { // Limit to 50 connections
            Connection::create($connectionData);
        }
        
        $this->command->info('User connections created successfully!');
    }
}
