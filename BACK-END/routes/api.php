<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User CRUD;
Route::post('registro', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('login', [\App\Http\Controllers\UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::patch('edit', [\App\Http\Controllers\UserController::class, 'edit']);
}); 
