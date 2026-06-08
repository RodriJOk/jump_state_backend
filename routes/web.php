<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/politica-de-privacidad', 'privacy-policy')->name('privacy-policy');
Route::view('/eliminacion-de-cuenta', 'account-deletion')->name('account-deletion');
