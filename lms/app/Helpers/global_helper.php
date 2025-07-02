<?php


use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


if (!function_exists('convertMinutesToHours')) {
    function convertMinutesToHours(int $minutes): string {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return sprintf('%dh %02dm', $hours, $minutes); // ✅ Corrected: %02dm
    }
}

if(!function_exists('user')) {
    function user() {
        return auth('web')->user();
    }
}


if(!function_exists('adminUser')) {
    function adminUser() {
        return auth('admin')->user();
    }
}


/* Cart count */
if(!function_exists('cartCount')) {
    function cartCount() {
        return Cart::where('user_id', Auth::id())->count();
    }
}
/** calculate cart total */
if(!function_exists('cartTotal')) {
    function cartTotal() {
        $total = 0;

        $cart = Cart::where('user_id', Auth::id())->get();

        foreach($cart as $item) {
            if($item->course->discount > 0) {
                $total += $item->course->discount;
            }else {
                $total += $item->course->price;
            }
        }

        return $total;
    }
}

/** calculate cart total */
if(!function_exists('calculateCommission')) {
    function calculateCommission($amount, $commission) {
        return $amount == 0 ? 0 : ($amount * $commission) / 100;
    }
}

/** Sidebar Item Active */
if(!function_exists('sidebarItemActive')) {
    function sidebarItemActive(array $routes) {

        foreach($routes as $route) {
            if(request()->routeIs($route)) {
                return 'active';
            }
        }
    }
}


