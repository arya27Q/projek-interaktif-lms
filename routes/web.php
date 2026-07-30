<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\gamification\GamificationController;
use App\Http\Controllers\profile\UserController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CoursePlayerController;

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
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        
        // Rute Gamifikasi
        Route::get('/gamification/leaderboard', [GamificationController::class, 'getLeaderboard']);
        Route::get('/gamification/streak', [GamificationController::class, 'getStreak']);
        
        // Rute Kelas & Katalog
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
        
        // Rute Pemutar Kelas & Catatan
        Route::get('/player/course/{id}', [CoursePlayerController::class, 'getContent']);
        Route::get('/player/lesson/{id}/notes', [CoursePlayerController::class, 'getNotes']);
        Route::post('/player/lesson/{id}/notes', [CoursePlayerController::class, 'saveNote']);
    });
});

// PENTING: Semua URL apapun (login, register, dashboard) 
// akan diarahkan ke 1 file tampilan utama, di mana Vue.js hidup!
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
