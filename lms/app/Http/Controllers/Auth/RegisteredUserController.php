<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
    use App\Traits\FileUpload;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    use FileUpload;
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->type === 'student'){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student', // Default role
                'approve_status'=>'approved'
            ]);
        }
        elseif($request ->type === 'instructor'){
            $request->validate(['document'=>['required','mimes:pdf,doc,docx,jpg,png','max:12000']]);
            $filePath = $this->uploadFile($request -> file('document'));
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student', // Default role
                'approve_status'=>'pending',
                'document' => $filePath
            ]);
        }
        else{
            abort(404);
        }


        event(new Registered($user));

        Auth::login($user);
        if($request->user()->role == 'student'){
            return redirect()->intended(route('student.dashboard'));
        }elseif($request->user()->role == 'instructor'){
            return redirect()->intended(route('frontend.instructor.dashboard'));
        }
    }
}
