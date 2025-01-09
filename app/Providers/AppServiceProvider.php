<?php

namespace App\Providers;

use App\Contracts\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Route;
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
        Route::pattern('id', '[0-9]+');
        Route::pattern('slug', '[a-z0-9-]+');
    }
}
