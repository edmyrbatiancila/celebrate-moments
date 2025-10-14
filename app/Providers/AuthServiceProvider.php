<?php

namespace App\Providers;

use App\Models\CreatorProfile;
use App\Models\Greeting;
use App\Policies\CreatorProfilePolicy;
use App\Policies\GreetingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CreatorProfile::class => CreatorProfilePolicy::class,
        Greeting::class => GreetingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}