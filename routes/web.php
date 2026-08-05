<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\gamification\GamificationController;
use App\Http\Controllers\profile\UserController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CoursePlayerController;
use App\Http\Controllers\Course\InstructorController;
use App\Http\Controllers\Course\CheckoutController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', function () { return view('welcome'); })->name('login');
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
        
        // Progress, Quiz, Bookmark & Diskusi
        Route::post('/player/lesson/{id}/progress', [CoursePlayerController::class, 'updateProgress']);
        Route::post('/player/lesson/{id}/bookmark', [CoursePlayerController::class, 'toggleBookmark']);
        Route::post('/player/lesson/{id}/quiz', [CoursePlayerController::class, 'submitQuiz']);
        Route::get('/player/lesson/{id}/discussions', [CoursePlayerController::class, 'getDiscussions']);
        Route::post('/player/lesson/{id}/discussions', [CoursePlayerController::class, 'postDiscussion']);

        // Rute Checkout
        Route::post('/checkout/{id}/process', [CheckoutController::class, 'process']);
        Route::post('/checkout/{orderId}/verify', [CheckoutController::class, 'verify']);

        // Rute Instructor Studio
        Route::middleware(['role:instructor,admin'])->prefix('instructor')->group(function () {
            Route::get('/courses', [InstructorController::class, 'getCourses']);
            Route::post('/courses', [InstructorController::class, 'storeCourse']);
            Route::get('/courses/{id}', [InstructorController::class, 'getCourseDetails']);
            Route::post('/courses/{id}', [InstructorController::class, 'updateCourse']);
            Route::post('/courses/{id}/publish', [InstructorController::class, 'publishCourse']);
            Route::post('/courses/{id}/modules', [InstructorController::class, 'storeModule']);
            Route::post('/modules/{id}/lessons', [InstructorController::class, 'storeLesson']);
        });
    });
});

// PENTING: Semua URL apapun (login, register, dashboard) 
// akan diarahkan ke 1 file tampilan utama, di mana Vue.js hidup!
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
