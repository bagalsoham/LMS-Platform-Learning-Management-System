<?php

namespace App\Http\Controllers\Admin;

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
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseContentController; // Missing import added here
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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::get('instructor-doc-download/{user}', [InstructorRequestController::class, 'download'])->name('instructor-doc-download');

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


    //admin course routes
    Route::get('courses', [CourseController::class, 'index'])->name('course.index');
    Route::put('courses/{course}/update-approval', [CourseController::class, 'updateApproval'])->name('course.update-approval');
    Route::get('courses/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('courses/create', [CourseController::class, 'storeBasicInfo'])->name('course.store-basic-info');


    Route::get('courses/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('courses/{id}/update', [CourseController::class, 'update'])->name('course.update');

    Route::get('course-content/{course}/create-chapter', [CourseContentController::class, 'createChapterModal'])->name('course-content.create-chapter');

    Route::get('course-content/{chapterId}/edit-chapter', [CourseContentController::class, 'editChapterModal'])->name('course-content.edit-chapter');

    Route::put('course-content/{chapterId}/update-chapter', [CourseContentController::class, 'updateChapterModal'])->name('course-content.update-chapter');

    Route::post('course-content/{course}/create-chapter', [CourseContentController::class, 'storeChapter'])->name('course-content.store-chapter');

    Route::delete('course-content/{chapter}/chapter', [CourseContentController::class, 'destroyChapter'])->name('course-content.destroy-chapter');

    Route::get('course-content/create-lesson', [CourseContentController::class, 'createLesson'])->name('course-content.create-lesson');
    Route::post('course-content/create-lesson', [CourseContentController::class, 'storeLesson'])
        ->name('course-content.store-lesson');

    /* Lesson modal routes */
    Route::get('course-content/edit-lesson', [CourseContentController::class, 'editLesson'])->name('course-content.edit-lesson'); // For loading the edit modal via AJAX
    Route::post('course-content/{id}/update-lesson', [CourseContentController::class, 'updateLesson'])->name('course-content.update-lesson'); // For submitting the edit form

    Route::delete('course-content/{id}/lesson', [CourseContentController::class, 'destroyLesson'])->name('course-content.destroy-lesson');

    Route::post('course-chapter/{chapter}/sort-lesson', [CourseContentController::class, 'sortLesson'])->name('course-content.sort-lesson'); // For submitting the sorted lesson order

    Route::get('course-content/{course}/sort-chapter', [CourseContentController::class, 'sortChapter'])->name('course-content.sort-chapter'); // For loading the sorted chapter order

    Route::post('course-content/{course}/sort-chapter', [CourseContentController::class, 'updateSortChapter'])->name('course-content.update-sort-chapter'); // Fixed the method name

    /* Order Controller */
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');


    /* Payment Setting routes */
    Route::get('payment-setting', [PaymentSettingController::class, 'index'])->name('payment-setting.index');

    Route::post('paypal-setting', [PaymentSettingController::class, 'paypalSetting'])->name('paypal-setting.update');
    Route::post('stripe-setting', [PaymentSettingController::class, 'stripeSetting'])->name('stripe-setting.update');
    Route::post('razorpay-setting', [PaymentSettingController::class, 'razorpaySetting'])->name('razorpay-setting.update');

     /** Site Settings Route */
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('general-settings', [SettingController::class, 'updateGeneralSettings'])->name('general-settings.update');
    Route::get('commission-settings', [SettingController::class, 'commissionSettingIndex'])->name('commission-settings.index');
    Route::post('commission-settings', [SettingController::class, 'updateCommissionSetting'])->name('commission-settings.update');

    Route::get('smtp-settings', [SettingController::class, 'smtpSetting'])->name('smtp-settings.index');
    Route::post('smtp-settings', [SettingController::class, 'updateSmtpSetting'])->name('smtp-settings.update');

    Route::get('logo-settings', [SettingController::class, 'logoSettingIndex'])->name('logo-settings.index');
    Route::post('logo-settings', [SettingController::class, 'updateLogoSetting'])->name('logo-settings.update');

    /* Payout routes */
    Route::resource('payout-gateway', PayoutGatewayController::class);

     /** Withdrawal routes */
    Route::get('withdraw-requests', [WithdrawRequestController::class, 'index'])->name('withdraw-request.index');
    Route::get('withdraw-requests/{withdraw}/details', [WithdrawRequestController::class, 'show'])->name('withdraw-request.show');
    Route::post('withdraw-requests/{withdraw}/status', [WithdrawRequestController::class, 'updateStatus'])->name('withdraw-request.status.update');


    // Laravel File Manager routes for admin and web
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});

