<?php

namespace App\Providers;

use App\Repositories\CreatorProfileRepository;
use App\Repositories\Interfaces\CreatorProfileRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CreatorProfileRepositoryInterface::class, CreatorProfileRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
