<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::firstOrCreate(
        //     ['email' => 'admin@gmail.com'],
        //     [
        //         'name' => 'Admin Nistrator',
        //         'password' => Hash::make('password'),
        //         'email_verified_at' => now(),
        //         'is_creator' => true,
        //         'is_verified_creator' => true,
        //         'current_role' => 'creator'
        //     ]
        // );
        $this->call([
            UserSeeder::class,
            CreatorProfileSeeder::class,
            TemplateSeeder::class,
            GreetingSeeder::class,
            GreetingAnalyticsSeeder::class
        ]);
    }
}
