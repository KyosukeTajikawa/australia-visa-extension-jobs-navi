<?php

namespace App\Providers;

use App\Repositories\FarmRepository;
use App\Repositories\FarmRepositoryInterface as RepositoriesFarmRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoriesFarmRepositoryInterface::class, FarmRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
