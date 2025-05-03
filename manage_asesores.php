<?php

require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asesor;
use Illuminate\Support\Facades\Hash;

echo "===== LISTA DE ASESORES ACTUALES =====\n";
$asesores = Asesor::all();
foreach ($asesores as $asesor) {
    echo "ID: {$asesor->id}, Nombre: {$asesor->nombre}, Email: {$asesor->email}\n";
}

echo "\n===== ELIMINANDO USUARIO DE PRUEBA =====\n";
// Eliminamos todos los usuarios que no son los que vamos a crear
// Si prefieres eliminar uno específico, reemplaza la siguiente línea con:
// $deleted = Asesor::where('id', ID_DEL_USUARIO_A_ELIMINAR)->delete();
$deleted = Asesor::whereNotIn('email', ['patricia.rayon@udg.com', 'pedro.rodriguez@udg.com'])->delete();
echo "Usuarios eliminados: $deleted\n";

echo "\n===== CREANDO NUEVOS ASESORES =====\n";

// Verificar si Patricia ya existe y eliminarla para re-crearla
$patricia = Asesor::where('email', 'patricia.rayon@udg.com')->first();
if ($patricia) {
    $patricia->delete();
    echo "Usuario existente 'patricia.rayon@udg.com' eliminado para recrearlo\n";
}

// Crear Patricia
$asesor1 = new Asesor();
$asesor1->nombre = 'Patricia Rayon';
$asesor1->email = 'patricia.rayon@udg.com';
$asesor1->password = Hash::make('1234');
$asesor1->especialidad = 'Desarrollo Web';
$asesor1->save();
echo "Usuario creado: Patricia Rayon (patricia.rayon@udg.com)\n";

// Verificar si Pedro ya existe y eliminarlo para re-crearlo
$pedro = Asesor::where('email', 'pedro.rodriguez@udg.com')->first();
if ($pedro) {
    $pedro->delete();
    echo "Usuario existente 'pedro.rodriguez@udg.com' eliminado para recrearlo\n";
}

// Crear Pedro
$asesor2 = new Asesor();
$asesor2->nombre = 'Pedro Rodriguez';
$asesor2->email = 'pedro.rodriguez@udg.com';
$asesor2->password = Hash::make('5678');
$asesor2->especialidad = 'Desarrollo Móvil';
$asesor2->save();
echo "Usuario creado: Pedro Rodriguez (pedro.rodriguez@udg.com)\n";

echo "\n===== LISTA DE ASESORES ACTUALIZADA =====\n";
$asesores = Asesor::all();
foreach ($asesores as $asesor) {
    echo "ID: {$asesor->id}, Nombre: {$asesor->nombre}, Email: {$asesor->email}\n";
}
