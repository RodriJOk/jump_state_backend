<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/politica-de-privacidad', 'privacy-policy')->name('privacy-policy');
