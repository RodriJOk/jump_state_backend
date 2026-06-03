<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;

// Rutas públicas (sin autenticación)
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/existing', [AuthController::class, 'existingUser'])->name('existingUser');
Route::get('/forget_password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

// Rutas protegidas (requieren autenticación con Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('api.changePassword');
    
    // Aquí puedes agregar más rutas protegidas según tus necesidades
    // Ejemplo:
    // Route::apiResource('cards', CardController::class);
    // Route::apiResource('subscriptions', SubscriptionController::class);
});
