<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Requests\Frontend\SocialUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Traits\FileUpload;

class ProfileController extends Controller
{
    use FileUpload;

    public function index():View{
        return view('frontend.student.profile.index');
    }
    public function instructorIndex():View{
        return view('frontend.instructor.profile.index');
    }
    public function profileUpdate(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $avatarPath = $this->uploadFile($request->file('avatar'));
            $user->image = $avatarPath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->about;
        $user->headline = $request->headline;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
    public function updateSocial(SocialUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->facebook = $request->facebook;
        $user->twitter = $request->x;
        $user->linkedin = $request->linkedin;
        $user->website = $request->website;
        $user->save();

        return redirect()->back();
    }
}
