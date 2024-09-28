<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// Scramble
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Scramble::ignoreDefaultRoutes();

        $this->app->bind(
            'App\Interfaces\LocationRepositoryInterface', 
            'App\Repositories\LocationRepository'
        );

        $this->app->bind(
            'App\Interfaces\DeviceRepositoryInterface', 
            'App\Repositories\DeviceRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
