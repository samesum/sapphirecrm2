<?php

namespace App\Providers;

use App\Models\Addon_hook;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        if(DB::connection()->getDatabaseName() != 'db_name') {
            // Dynamically load service providers from the addons folder
            $addonsPath = app_path('Addons');
            
            if (File::isDirectory($addonsPath)) {
                // Scan all addon directories
                $addons = File::directories($addonsPath);
    
                foreach ($addons as $addon) {
                    $providerPath = $addon . '/Providers/AddonServiceProvider.php';
                    // Check if AddonServiceProvider exists
                    if (File::exists($providerPath)) {
                        $namespace = 'App\\Addons\\' . basename($addon) . '\\Providers\\AddonServiceProvider';
                        // Register the service provider
                        $this->app->register($namespace);
                    }
    
                    // Load views if the views folder exists in the addon
                    $viewsPath = $addon . '/views';
                    if (File::isDirectory($viewsPath)) {
                        $viewNamespace = basename($addon);
                        $this->loadViewsFrom($viewsPath, $viewNamespace);
                    }

    
                    if (File::isDirectory($viewsPath)) {
                        $viewNamespace = basename($addon);
                        $this->loadViewsFrom($viewsPath, $viewNamespace);
                    }
                    
                    // Load migrations if the migrations folder exists in the addon
                    $migrationsPath = $addon . '/database/migrations';
                    if (File::isDirectory($migrationsPath)) {
                        $this->loadMigrationsFrom($migrationsPath);
                    }
                }
            }
        }
        
    }
}
