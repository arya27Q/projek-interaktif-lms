<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::get('/auth/{provider}/redirect', 'redirectSocial');
        Route::get('/auth/{provider}/callback', 'callbackSocial');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/auth/me', function (Illuminate\Http\Request $request) {
            return response()->json([
                'success' => true,
                'user' => $request->user()
            ]);
        });
        Route::put('/user/profile', [App\Http\Controllers\UserController::class, 'updateProfile']);
    });
});

// PENTING: Semua URL apapun (login, register, dashboard) 
// akan diarahkan ke 1 file tampilan utama, di mana Vue.js hidup!
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
