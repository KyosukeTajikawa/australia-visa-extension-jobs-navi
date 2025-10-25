<?php

namespace App\Providers;

use App\Repositories\FarmRepository;
use App\Repositories\FarmRepositoryInterface;
use App\Repositories\StateRepository;
use App\Repositories\StateRepositoryInterface;
use App\Services\FarmImagesService;
use App\Services\FarmImagesServiceInterface;
use App\Services\FarmService;
use App\Services\FarmServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FarmRepositoryInterface::class, FarmRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(FarmServiceInterface::class, FarmService::class);
        $this->app->bind(FarmImagesServiceInterface::class, FarmImagesService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
