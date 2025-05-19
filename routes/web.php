<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Añadir una ruta simple de verificación de salud
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});
