<?php

use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; // Added for profile routes
use App\Http\Controllers\Frontend\FrontendController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
|
| The main landing page of your application.
|
*/
Route::get('/',[FrontendController::class,'index'])->name('home');
/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
|
| Redirects the user to their role-specific dashboard (student/instructor)
| based on their authenticated role.
|
*/
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();

        // Check if the authenticated user has a role
        if (isset($user->role)) {
            if ($user->role === 'student') {
                return redirect()->route('frontend.student.dashboard');
            } elseif ($user->role === 'instructor') {
                return redirect()->route('instructor.dashboard');
            }
        }
    }

    // If not authenticated or role not matched, redirect to home
    return redirect('/');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Routes accessible only to authenticated users with the "student" role.
| Applies 'auth:web', 'verified', and 'checkRole:student' middlewares.
|
*/
Route::group([
    'middleware' => ['auth:web', 'verified', 'checkRole:student'],
    'prefix' => 'student',
    'as' => 'student.'
], function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
|
| Routes accessible only to authenticated users with the "instructor" role.
| Applies 'auth:web', 'verified', and 'checkRole:instructor' middlewares.
|
*/
Route::group([
    'middleware' => ['auth:web', 'verified', 'checkRole:instructor'],
    'prefix' => 'instructor',
    'as' => 'instructor.'
], function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| Routes for user profile management.
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Route Files
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';   // For default web users
require __DIR__.'/admin.php';  // For admin-specific routes
