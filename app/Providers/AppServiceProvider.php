<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Services\AuthServiceInterface;
use Infrastructure\Services\AuthService;
use Domain\Repositories\ProductRepositoryInterface;
use Infrastructure\Persistence\Eloquent\Repositories\EloquentProductRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
