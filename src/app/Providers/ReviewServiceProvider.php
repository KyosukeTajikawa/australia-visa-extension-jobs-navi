<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Reviews\ReviewRepository;
use App\Repositories\Reviews\ReviewRepositoryInterface;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
