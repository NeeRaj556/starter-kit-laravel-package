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
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('catalyst-starterKit-fastApi.php'),
        ]);
        $filesToCopy = [
            __DIR__ . '/../src/Controllers/ProductController.php' => app_path('Http/Controllers/ProductController.php'),
            __DIR__ . '/../src/Requests/StoreProductRequest.php' => app_path('Http/Requests/StoreProductRequest.php'),
            __DIR__ . '/../src/Requests/UpdateProductRequest.php' => app_path('Http/Requests/UpdateProductRequest.php'),
        ];
    
        foreach ($filesToCopy as $source => $destination) {
            if (!File::exists($destination)) {
                File::ensureDirectoryExists(dirname($destination));
                File::copy($source, $destination);
            }
        }
    }
}
