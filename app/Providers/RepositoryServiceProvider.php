<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Repositories\ProductRepository;
use App\Domain\Repositories\SaleRepositoryInterface;
use App\Infrastructure\Repositories\SaleRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
