<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index():View{
        return view('frontend.student.profile.index');
    }
    public function profileUpdate(ProfileUpdateRequest $request):RedirectResponse{
        $user = Auth::user();
        $user -> name= $request->name;
        $user -> email= $request->email;
        $user -> bio= $request->about;
        $user -> headline= $request->headline;
        $user -> gender= $request->gender;
        $user -> save();

        return redirect()->back();
    }
}
