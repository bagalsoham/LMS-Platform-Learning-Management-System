<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Jab user authenticated hai to usse kahaan redirect karna hai,
     * yeh callback yahan store hoga (agar set kiya gaya ho).
     */
    protected static $redirectToCallback;

    /**
     * Handle incoming request.
     * Agar user already authenticated hai, to usse redirect karo.
     * Agar nahi, to request ko next middleware ya controller tak bhej do.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Agar koi guard nahi diya, to null guard use karo (default web guard).
        $guards = empty($guards) ? [null] : $guards;

        // Har guard ke liye check karo ki user authenticated hai ya nahi.
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Agar login hai, to redirect karo appropriate route pe.
                return redirect($this->redirectTo($request, $guard));
            }
        }

        // Agar user authenticated nahi hai, to request ko continue hone do.
        return $next($request);
    }

    /**
     * Authenticated user ko kahaan redirect karna chahiye yeh decide karta hai.
     * Agar custom callback set kiya gaya ho to use use karo, warna default route.
     */
    protected function redirectTo(Request $request, ?string $guard): ?string
    {
        return static::$redirectToCallback
            ? call_user_func(static::$redirectToCallback, $request)
            : $this->defaultRedirectUri($guard);
    }

    /**
     * Agar koi custom redirect callback nahi mila to
     * yeh default redirect URI provide karega guard ke basis pe.
     */
    protected function defaultRedirectUri(?string $guard): string
    {
        // Har guard ke liye corresponding named route map kiya gaya hai.
        $routes = [
            'admin' => 'admin.dashboard',
            'web'   => 'dashboard',
        ];

        // Check karo ki guard ka route defined hai ya nahi.
        if (array_key_exists($guard, $routes)) {
            $routeName = $routes[$guard];

            // Agar route exist karta hai, to uska URL return karo.
            if (Route::has($routeName)) {
                return route($routeName);
            }
        }

        // Agar koi route match nahi hua, to home page redirect karo.
        return '/';
    }

    /**
     * Developer yeh method use karke custom redirect callback set kar sakta hai.
     * Is callback ka use redirectTo() method mein hoga.
     */
    public static function redirectUsing(callable $redirectToCallback)
    {
        static::$redirectToCallback = $redirectToCallback;
    }
}
