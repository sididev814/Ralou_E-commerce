<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // ✅ NE PAS oublier cette ligne

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
        // ✅ Active le style Bootstrap 5 pour les liens de pagination
        Paginator::useBootstrapFive(); // ou useBootstrapFour() selon ton CSS
    }
}
