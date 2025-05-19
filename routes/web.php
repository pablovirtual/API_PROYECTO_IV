<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add a health check endpoint
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});
