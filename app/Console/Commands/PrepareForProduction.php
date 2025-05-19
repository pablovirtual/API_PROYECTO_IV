<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareForProduction extends Command
{
    protected $signature = 'app:prepare-for-production';
    protected $description = 'Prepares the application for production environment';

    public function handle()
    {
        $this->info('Preparing application for production...');
        
        // Verificar configuración crítica
        $this->checkEnvironment();
        
        // Optimizar la aplicación
        $this->call('config:cache');
        $this->call('route:cache');
        
        // Verificar permisos
        $this->checkPermissions();
        
        $this->info('Application is ready for production!');
        return Command::SUCCESS;
    }
    
    private function checkEnvironment()
    {
        $this->info('Checking environment configuration...');
        
        // Verificar que APP_KEY está configurado
        if (empty(env('APP_KEY'))) {
            $this->error('APP_KEY not set! Generating...');
            $this->call('key:generate');
        }
        
        // Verificar conexión a la base de datos
        try {
            \DB::connection()->getPdo();
            $this->info('Database connection successful!');
        } catch (\Exception $e) {
            $this->error('Could not connect to the database: ' . $e->getMessage());
        }
    }
    
    private function checkPermissions()
    {
        $this->info('Setting directory permissions...');
        
        $directories = [
            storage_path(),
            storage_path('app'),
            storage_path('framework'),
            storage_path('logs'),
            base_path('bootstrap/cache')
        ];
        
        foreach ($directories as $directory) {
            if (!is_writable($directory)) {
                $this->error("Directory not writable: $directory");
                $this->info("Attempting to set permissions...");
                chmod($directory, 0777);
            }
        }
    }
}
