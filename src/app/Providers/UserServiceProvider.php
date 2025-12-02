<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Auth\UserRepositoryInterface;
use App\Services\UserImageService;
use App\Services\UserImageServiceInterface;
use App\Services\UserServiceInterface;
use App\Services\UserService;
use App\Repositories\Auth\UserImageRepositoryInterface;
use App\Repositories\Auth\UserImageRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserImageServiceInterface::class, UserImageService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserImageRepositoryInterface::class, UserImageRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
