<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Fix utf8mb4 index length for older MySQL / MariaDB versions
        Builder::defaultStringLength(191);

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
