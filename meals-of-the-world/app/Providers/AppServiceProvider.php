<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Pagination\CustomPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->alias(CustomPaginator::class, LengthAwarePaginator::class); 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
