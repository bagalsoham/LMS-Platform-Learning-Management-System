<?php

use App\Http\Controllers\Frontend\CourseContentController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProfileController;

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
                return redirect()->route('student.dashboard');
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
    Route::get('/become-instructor', [StudentDashboardController::class, 'becomeinstructor'])->name('become-instructor');
    Route::post('/become-instructor', [StudentDashboardController::class, 'becomeinstructorUpdate'])->name('become-instructor.update');

    /* Profile Routes */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/update-social', [ProfileController::class, 'updateSocial'])->name('profile.update-social');
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

    /* Profile Routes */
    Route::get('/profile', [ProfileController::class, 'instructorIndex'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/update-social', [ProfileController::class, 'updateSocial'])->name('profile.update-social');


    /* Course routes */
    /* Course routes */
Route::get('courses',[CourseController::class,'index'])->name('course.index');
Route::get('courses/create',[CourseController::class,'create'])->name('course.create');
Route::post('courses/create',[CourseController::class,'storeBasicInfo'])->name('course.store-basic-info');
Route::get('courses/{id}/edit',[CourseController::class,'edit'])->name('course.edit');
Route::post('courses/{id}/update',[CourseController::class,'update'])->name('course.update');

Route::get('course-content/{course}/create-chapter',[CourseContentController::class,'createChapterModal'])->name('course-content.create-chapter');
Route::post('course-content/{course}/create-chapter',[CourseContentController::class,'storeChapter'])->name('course-content.store-chapter');

Route::get('course-content/create-lesson',[CourseContentController::class,'createLesson'])->name('course-content.create-lesson');
Route::post('course-content/create-lesson', [CourseContentController::class, 'storeLesson'])
    ->name('course-content.store-lesson');

/* Lesson modal routes */
Route::get('course-content/edit-lesson', [CourseContentController::class, 'editLesson'])->name('course-content.edit-lesson'); // For loading the edit modal via AJAX
Route::post('course-content/{id}/update-lesson', [CourseContentController::class, 'updateLesson'])->name('course-content.update-lesson'); // For submitting the edit form

//laravel filemanager routes
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });
});

/*
|--------------------------------------------------------------------------
| Authentication Route Files
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';   // For default web users
require __DIR__.'/admin.php';  // For admin-specific routes
