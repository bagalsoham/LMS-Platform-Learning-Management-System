<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseLanguageController;
use App\Http\Controllers\Admin\CourseSubCategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstructorRequestController;
use App\Http\Controllers\Admin\CourseLevelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
|
| Routes under admin panel using the 'admin' guard.
| URL Prefix: /admin
| Route names: admin.*
|
*/

/* Guest Routes: Accessible only when NOT logged in as admin */
Route::prefix('admin')->name('admin.')->middleware(['guest:admin'])->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);


    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

/* Authenticated Routes: Accessible only when logged in as admin */
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');

    // Confirm Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    /*Instructor request route  */

    Route::get('instructor-doc-download/{user}',[InstructorRequestController::class,'download'])->name('instructor-doc-download');

    Route::resource('instructor-request', InstructorRequestController::class);

    /* Course Language controller  */
    Route::resource('course-languages', CourseLanguageController::class);

    /* Course Level controller  */
    Route::resource('course-levels', CourseLevelController::class);

    /* Categories */
    Route::resource('course-category', CourseCategoryController::class);

    Route::get('/course-category/{course_category}/sub-category', [CourseSubCategoryController::class, 'index'])->name('course-sub-category.index');

    Route::get('/course-category/{course_category}/sub-category/create', [CourseSubCategoryController::class, 'create'])->name('course-sub-category.create');

    Route::post('/course-category/{course_category}/sub-category', [CourseSubCategoryController::class, 'store',])->name('course-sub-category.store');

    Route::get('/course-category/{course_category}/sub-category/{course_sub_category}/edit', [CourseSubCategoryController::class, 'edit'])->name('course-sub-category.edit');


    Route::put('/course-category/{course_category}/sub-category/{course_sub_category}', [CourseSubCategoryController::class, 'update'])->name('course-sub-category.update');

    Route::delete('/course-category/{course_category}/sub-category/{course_sub_category}', [CourseSubCategoryController::class, 'destroy'])->name('course-sub-category.destroy');
});
