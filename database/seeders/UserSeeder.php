<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Creator
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Nistrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_creator' => true,
                'is_verified_creator' => true,
                'current_role' => 'creator',
                'timezone' => 'UTC'
            ]
        );

        // Test Creator
        User::firstOrCreate(
            ['email' => 'creator@test.com'],
            [
                'name' => 'Test Creator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_creator' => true,
                'is_verified_creator' => false,
                'current_role' => 'creator',
                'timezone' => 'UTC'
            ]
        );

        // Test Celebrant
        User::firstOrCreate(
            ['email' => 'celebrant@test.com'],
            [
                'name' => 'Test Celebrant',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_creator' => false,
                'is_verified_creator' => false,
                'current_role' => 'celebrant',
                'timezone' => 'UTC'
            ]
        );

        // Generate additional random users using factory
        User::factory(10)->celebrant()->create();
        User::factory(5)->creator()->create();
        User::factory(2)->verifiedCreator()->create();
    }
}
