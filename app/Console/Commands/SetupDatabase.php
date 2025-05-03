<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-database {--force : Forzar la ejecución en producción}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta las migraciones y seeders de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando configuración de la base de datos...');
        
        $force = $this->option('force') ? ['--force' => true] : [];
        
        try {
            $this->info('Ejecutando migraciones...');
            Artisan::call('migrate', $force);
            $this->info(Artisan::output());
            
            $this->info('Ejecutando seeders...');
            Artisan::call('db:seed', $force);
            $this->info(Artisan::output());
            
            $this->info('Base de datos configurada correctamente!');
            Log::info('Base de datos configurada mediante comando app:setup-database');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error al configurar la base de datos: ' . $e->getMessage());
            Log::error('Error al configurar base de datos: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
