<?php

namespace App\Providers;

use App\Repositories\FarmRepository;
use App\Repositories\FarmRepositoryInterface;
use App\Services\FarmService;
use App\Services\FarmServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FarmRepositoryInterface::class, FarmRepository::class);
        $this->app->bind(FarmServiceInterface::class, FarmService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
