<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public const API_NAMESPACE = 'App\\Http\\Controllers\\Api';    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        
        Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
    }
    

}
