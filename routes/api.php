<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/existing', [AuthController::class, 'existingUser'])->name('existingUser');
Route::get('/forget_password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
