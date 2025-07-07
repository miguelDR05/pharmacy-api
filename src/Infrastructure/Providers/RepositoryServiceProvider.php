<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Repositories\ProductRepositoryInterface;
use Infrastructure\Persistence\Eloquent\Repositories\EloquentProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
