<?php

namespace catalyst\StarterKitRestApi\Providers;

use Interfaces\CrudRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Interfaces\ProductRepositoryInterface;
use Repositories\CrudRepository;
use Illuminate\Support\Facades\File;


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
         $this->publishes([
            __DIR__.'/../config/config.php' => config_path('catalyst-starterKit-fastApi.php'),
        ]);
        $filesToCopy = [
            __DIR__ . '/../Http/Controllers/ProductController.php' => app_path('Http/Controllers/ProductController.php'),
            __DIR__ . '/../Http/Requests/BaseRequest.php' => app_path('Http/Requests/BaseRequest.php'),
            __DIR__ . '/../Http/Requests/StoreProductRequest.php' => app_path('Http/Requests/StoreProductRequest.php'),
            __DIR__ . '/../Http/Requests/UpdateProductRequest.php' => app_path('Http/Requests/UpdateProductRequest.php'),
            __DIR__ . '/../Models/BaseModel.php' => app_path('Http/Models/BaseModel.php'),
            __DIR__ . '/../Models/Product.php' => app_path('Http/Models/Product.php'),
            __DIR__ . '/../migration/2025_01_19_061857_create_products_table.php' => database_path('migrations/2025_01_19_061857_create_products_table.php'),
            
        ];
    
        foreach ($filesToCopy as $source => $destination) {
            if (!File::exists($destination)) {
            File::ensureDirectoryExists(dirname($destination));
            File::move($source, $destination);
            }
        }
        if (File::exists(base_path('.env'))) {
            $envContent = File::get(base_path('.env'));
            if (strpos($envContent, 'PAGINATE=') === false) {
            File::append(base_path('.env'), "\nPAGINATE=10");
            }
        } else {
            File::copy(base_path('.env.example'), base_path('.env'));
            File::append(base_path('.env'), "\nPAGINATE=10");
        }
        $this->callAfterResolving('migrator', function ($migrator) {
            $migrator->run(database_path('migrations'));
        });
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Tymon\JWTAuth\Console\JWTGenerateSecretCommand::class,
                \Illuminate\Foundation\Console\StorageLinkCommand::class,
            ]);
        }
        
       
    }
}
