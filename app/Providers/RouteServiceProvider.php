<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('client')
            ->name('client.')
            ->group(base_path('routes/client.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('staff')
            ->name('staff.')
            ->group(base_path('routes/staff.php'));
    }
}
