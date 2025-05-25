<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller; // Base controller ko import karte hain
use Illuminate\Http\RedirectResponse; // Redirect hone ke response ke liye
use Illuminate\Http\Request; // HTTP request ko handle karne ke liye
use Illuminate\Support\Facades\Password; // Password reset features ke liye Laravel ka facade
use Illuminate\View\View; // View return karne ke liye
use App\Notifications\ResetPassword; // Custom notification jo reset password email bhejti hai

/**
 * This controller handles the password reset functionality for admin users.
 * It provides two main functions:
 * 1. Display the forgot password form (create method)
 * 2. Process the password reset request (store method)
 * 
 * The store method validates the email, generates a reset token, and sends a reset link
 * to the admin's email address. The reset link is customized to use the admin-specific
 * routes and views. If the email is found in the admins table, a reset link will be sent;
 * otherwise, an error message will be shown.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('admin.auth.forgot-password'); // 'admin' panel ka forgot password form dikhata hai
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Email field ki validation karta hai - required aur valid email hona chahiye
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Password reset link send karne ki koshish karte hain
        $status = Password::broker('admins')->sendResetLink( 
            // 'admins' broker use kar rahe hain (guard based reset)
            $request->only('email'), // Request se sirf 'email' field le rahe hain
            function ($user, $token) { // Jab link generate hota hai tab ye callback execute hota hai
                $notification = new ResetPassword($token); // Custom notification ka object banate hain with token
                $notification->createUrlUsing(function () use ($user, $token) { // Reset link customize kar rahe hain
                    return route('admin.password.reset', [ // Admin panel kstoreet password route use ho raha hai
                        'token' => $token,
                        'email' => $user->email
                    ]);
                });
                $user->notify($notification); // Admin user ko reset password email send kar rahe hain
            }
        );

        // Agar link successfully bhej diya gaya
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status)) // Success message ke saath wapas bhejna
                    : back()->withInput($request->only('email')) // Fail hone par email field ke saath wapas bhejna
                        ->withErrors(['email' => __($status)]); // Error message dikhana
    }
}
