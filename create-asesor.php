<?php

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asesor;
use Illuminate\Support\Facades\Hash;

// Verificar si ya existe un asesor con este email
$existing = Asesor::where('email', 'asesor@ejemplo.com')->first();

if ($existing) {
    echo "Ya existe un asesor con este email. ID: " . $existing->id . "\n";
} else {
    // Crear el asesor
    $asesor = new Asesor;
    $asesor->nombre = 'Asesor Prueba';
    $asesor->email = 'asesor@ejemplo.com';
    $asesor->password = Hash::make('password123');
    $asesor->especialidad = 'Finanzas';
    $asesor->descripcion = 'Asesor de prueba para la API';
    $asesor->save();
    
    echo "Asesor creado exitosamente. ID: " . $asesor->id . "\n";
}

// Mostrar todos los asesores
$asesores = Asesor::all();
echo "Asesores en la base de datos: " . $asesores->count() . "\n";
foreach ($asesores as $a) {
    echo "- ID: " . $a->id . ", Nombre: " . $a->nombre . ", Email: " . $a->email . "\n";
}
