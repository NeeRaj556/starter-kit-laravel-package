<?php

namespace catalyst\StarterKitFastApi\Providers;

use Interfaces\CrudRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Interfaces\ProductRepositoryInterface;
use Repositories\CrudRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CrudRepositoryInterface::class, CrudRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
