<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->optional()->phoneNumber(),
            'timezone' => fake()->timezone(),
            'is_creator' => fake()->boolean(30),
            'is_verified_creator' => false,
            'current_role' => 'celebrant',
            'date_of_birth' => fake()->optional()->date('Y-m-d', '-18 years'),
            'two_factor_secret' => Str::random(10),
            'two_factor_recovery_codes' => Str::random(10),
            'two_factor_confirmed_at' => now(),
        ];
    }

    /**
     * Create a creator user.
     */
    public function creator(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_creator' => true,
            'current_role' => 'creator',
            'is_verified_creator' => fake()->boolean(70),
        ]);
    }

    /**
     * Create a verified creator.
     */
    public function verifiedCreator(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_creator' => true,
            'is_verified_creator' => true,
            'current_role' => 'creator'
        ]);
    }

    /**
     * Create a celebrant user.
     */
    public function celebrant(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_creator' => false,
            'is_verified_creator' => false,
            'current_role' => 'celebrant'
        ]);
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model does not have two-factor authentication configured.
     */
    public function withoutTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }
}
