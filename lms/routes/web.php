<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CourseContentController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\CoursePageController;
use App\Http\Controllers\Frontend\EnrolledCourseController;
use App\Http\Controllers\Frontend\FrontendContactController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\WithdrawController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;



/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
|
| The main landing page of your application.
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/courses', [CoursePageController::class, 'index'])->name('courses.index');
Route::get('/course/{slug}', [CoursePageController::class, 'show'])->name('courses.show');
/* Cart route */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('add-to-cart/{course}', [CartController::class, 'addToCart'])->name(name: 'add-to-cart')->middleware('auth');
Route::get('remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('remove-from-cart')->middleware('auth');

/** Payment Routes */
Route::get('checkout', action: CheckoutController::class)->name('checkout.index');


/* Paypal payment routes 3 routes where success and cancel will be there  */


Route::get('papal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
Route::get('papal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('papal/cancel', action: [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

Route::get('razorpay/redirect', [PaymentController::class, 'razorpayRedirect'])->name('razorpay.redirect');
Route::post('razorpay/payment', [PaymentController::class, 'payWithRazorpay'])->name('razorpay.payment');

Route::get('order-success', [PaymentController::class, 'orderSuccess'])->name('order.success');
Route::get('order-failed', [PaymentController::class, 'orderFailed'])->name('order.failed');

 Route::get('about', [FrontendController::class, 'about'])->name('about.index');
/** Blog Routes */
 Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
 Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
 Route::post('blog/comment/{id}', [BlogController::class, 'storeComment'])->name('blog.comment.store');

 Route::get('contact', [FrontendContactController::class, 'index'])->name('contact.index');
 Route::post('contact', [FrontendContactController::class, 'sendMail'])->name('send.contact');



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
    if (Auth::check()) {
        $user = Auth::user();

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

    /** Enroll Courses Routes */
    Route::get('enrolled-courses', [EnrolledCourseController::class, 'index'])->name('enrolled-courses.index');
    Route::get('course-player/{slug}', [EnrolledCourseController::class, 'playerIndex'])->name('course-player.index');
    Route::get('get-lesson-content', [EnrolledCourseController::class, 'getLessonContent'])->name('get-lesson-content');
    Route::post('update-watch-history', [EnrolledCourseController::class, 'updateWatchHistory'])->name('update-watch-history');
    Route::post('update-lesson-completion', [EnrolledCourseController::class, 'updateLessonCompletion'])->name('update-lesson-completion');
    Route::get('file-download/{id}', [EnrolledCourseController::class, 'fileDownload'])->name('file-download');

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
    Route::post('profile/update-gateway-info', [ProfileController::class, 'updateGatewayInfo'])->name('profile.update-gateway-info');



    /* Course routes */
    Route::get('courses', [CourseController::class, 'index'])->name('course.index');
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
    Route::delete('course-content/{lesson}/lesson', [CourseContentController::class, 'destroyLesson'])->name('course-content.destroy-lesson');

    Route::post('course-chapter/{chapter}/sort-lesson', [CourseContentController::class, 'sortLesson'])->name('course-content.sort-lesson'); // For submitting the sorted lesson order

    Route::get('course-content/{course}/sort-chapter', [CourseContentController::class, 'sortChapter'])->name('course-content.sort-chapter'); // For loading the sorted chapter order

    Route::post('course-content/{course}/sort-chapter', [CourseContentController::class, 'updateSortChapter'])->name('course-content.update-sort-chapter'); // For updating the sorted chapter order


    /** Orders Routes */
    Route::get('orders', [FrontendOrderController::class, 'index'])->name('orders.index');

    /** Withdrawal routes */
    Route::get('withdrawals', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('withdrawals/request-payout', [WithdrawController::class, 'requestPayoutIndex'])->name('withdraw.request-payout');
    Route::post('withdrawals/request-payout', [WithdrawController::class, 'requestPayout'])->name('withdraw.request-payout.create');



    //laravel filemanager routes
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});


/* // Add this to a test route or controller to debug
Route::get('/debug-structure', function() {
    $publicStorage = public_path('storage');
    $storageAppPublic = storage_path('app/public');

    return [
        'public_path' => public_path(),
        'public_storage_path' => $publicStorage,
        'storage_app_public_path' => $storageAppPublic,
        'public_storage_contents' => is_dir($publicStorage) ? scandir($publicStorage) : 'Directory not found',
        'storage_app_public_contents' => is_dir($storageAppPublic) ? scandir($storageAppPublic) : 'Directory not found',
        'app_url' => config('app.url'),
        'current_url' => request()->getSchemeAndHttpHost(),
    ];
}); */

/*
|--------------------------------------------------------------------------
| Authentication Route Files
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';   // For default web users
require __DIR__ . '/admin.php';  // For admin-specific routes
