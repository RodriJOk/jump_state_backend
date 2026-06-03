<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
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
    
    //Usuario
    Route::get('/user', [UserController::class, 'getUser'])->name('api.getUser');
    
    // Progreso del juego
    Route::get('/user/progress', [UserController::class, 'getProgress'])->name('api.getProgress');
    Route::post('/user/progress/level/{levelId}', [UserController::class, 'saveProgress'])->name('api.saveProgress');
    
    // Puntuaciones y récords
    Route::get('/user/scores', [UserController::class, 'getScores'])->name('api.getScores');
    Route::post('/user/scores/level/{levelId}', [UserController::class, 'saveScore'])->name('api.saveScore');
    
    // Leaderboard
    Route::get('/leaderboard/global', [LeaderboardController::class, 'getGlobalLeaderboard'])->name('api.globalLeaderboard');
    Route::get('/leaderboard/level/{levelId}', [LeaderboardController::class, 'getLevelLeaderboard'])->name('api.levelLeaderboard');
});
