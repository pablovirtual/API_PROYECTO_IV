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
        // Ejecutar migraciones y seeders automáticamente en producción
        if (app()->environment('production')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
                Log::info('Migraciones y seeders ejecutados automáticamente en el arranque de la aplicación');
            } catch (\Exception $e) {
                Log::error('Error al ejecutar migraciones/seeders automáticos: ' . $e->getMessage());
            }
        }
    }
}
