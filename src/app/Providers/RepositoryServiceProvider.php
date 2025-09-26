<?php

namespace App\Providers;

use App\Interfaces\FarmRepositoryInterface;
use App\Repositories\FarmRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(FarmRepositoryInterface::class, FarmRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
