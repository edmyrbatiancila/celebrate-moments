<?php

namespace App\Providers;

use App\Repositories\ConnectionRepository;
use App\Repositories\CreatorProfileRepository;
use App\Repositories\GreetingRepository;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use App\Repositories\Interfaces\CreatorProfileRepositoryInterface;
use App\Repositories\Interfaces\GreetingRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\TemplateRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\TemplateRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CreatorProfileRepositoryInterface::class, CreatorProfileRepository::class);
        $this->app->bind(GreetingRepositoryInterface::class, GreetingRepository::class);
        $this->app->bind(MediaRepositoryInterface::class, MediaRepository::class);
        $this->app->bind(TemplateRepositoryInterface::class, TemplateRepository::class);
        $this->app->bind(ConnectionRepositoryInterface::class, ConnectionRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
