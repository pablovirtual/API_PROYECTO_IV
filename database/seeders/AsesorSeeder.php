<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existen asesores para evitar duplicados
        if (DB::table('asesores')->where('email', 'patricia.payeRayon@udg.com')->count() === 0) {
            DB::table('asesores')->insert([
                'nombre' => 'Patricia Rayon',
                'email' => 'patricia.Rayon@udg.com',
                'password' => Hash::make('1234'), // Cambia esto por la contraseña correcta
                'especialidad' => 'Desarrollo Web y Móvil',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        if (DB::table('asesores')->where('email', 'pedro.rodriguez@udg.com')->count() === 0) {
            DB::table('asesores')->insert([
                'nombre' => 'Pedro Rodriguez',
                'email' => 'pedro.rodriguez@udg.com',
                'password' => Hash::make('5678'), // Cambia esto por la contraseña correcta
                'especialidad' => 'Desarrollo Móvil',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
