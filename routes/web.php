<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add a simple health check route
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});
