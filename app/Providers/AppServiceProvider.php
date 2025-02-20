<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EnumService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EnumService::class, function ($app) {
            return new EnumService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
