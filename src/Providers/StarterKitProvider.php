<?php

namespace src\Providers;

use Illuminate\Support\ServiceProvider;


class StarterKitProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('catalyst-starterKit-fastApi.php'),
        ]);
    }
}
