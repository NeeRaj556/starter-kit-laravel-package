<?php

namespace src\Providers;

use src\Interfaces\CrudRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use src\Interfaces\ProductRepositoryInterface;
use src\Repositories\CrudRepository;

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
