<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', 'logout');
    });
});

// PENTING: Semua URL apapun (login, register, dashboard) 
// akan diarahkan ke 1 file tampilan utama, di mana Vue.js hidup!
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
