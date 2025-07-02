<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class CartController extends Controller
{
    function index(): View
    {
        $cart = Cart::with('course')->where('user_id', Auth::guard('web')->id())->paginate();
        return view('frontend.pages.cart', compact('cart'));
    }

    public function addToCart(int $id): Response
    {
        if (!Auth::guard('web')->check()) {
            return response(['message' => 'Please Login First!'], 401);
        }

        $user = Auth::guard('web')->user();

        if (Cart::where(['course_id' => $id, 'user_id' => $user->id])->exists()) {
            return response(['message' => 'Already Added!'], 401);
        }

        if ($user->role === 'instructor') {
            return response(['message' => 'Please use a user account to add to cart!'], 401);
        }

        $course = Course::findOrFail($id);

        $cart = new Cart();
        $cart->course_id = $course->id;
        $cart->user_id = $user->id;
        $cart->save();

        return response(['message' => 'Added Successfully'], 200);
    }

    function removeFromCart(int $id): RedirectResponse
    {
        $cart = Cart::where([
            'id' => $id,
            'user_id' => Auth::id()
        ])->firstOrFail();
        $cart->delete();
        notyf()->success('Removed Successfully!');
        return redirect()->back();
    }
}
