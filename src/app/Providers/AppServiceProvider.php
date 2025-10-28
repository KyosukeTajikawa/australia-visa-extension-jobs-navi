<?php

namespace App\Providers;

use App\Repositories\Farms\FarmRepository;
use App\Repositories\Farms\FarmRepositoryInterface;
use App\Repositories\FarmImageRepository;
use App\Repositories\FarmImageRepositoryInterface;
use App\Repositories\StateRepository;
use App\Repositories\StateRepositoryInterface;
use App\Repositories\Reviews\ReviewRepository;
use App\Repositories\Reviews\ReviewRepositoryInterface;
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
        $this->app->bind(FarmImageRepositoryInterface::class, FarmImageRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(FarmImagesServiceInterface::class, FarmImagesService::class);
        $this->app->bind(FarmServiceInterface::class, FarmService::class);
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
