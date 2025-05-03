<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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
        // Ejecutar migraciones automáticamente en producción
        if (app()->environment('production')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Log::info('Migraciones ejecutadas automáticamente en el arranque de la aplicación');
            } catch (\Exception $e) {
                Log::error('Error al ejecutar migraciones automáticas: ' . $e->getMessage());
            }
        }
    }
}
