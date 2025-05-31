@extends('frontend.layouts.master')

@section('content')
<section class="wsus__sign_in wsus__sign_in">
    <div class="row align-items-center">
        <div class="col-xxl-5 col-xl-6 col-lg-6 wow fadeInLeft">
            <div class="wsus__sign_img">
                <img src="{{asset('frontend/assets/images/login_img_2.jpg')}}" alt="register" class="img-fluid">
                <a href="{{ route('home') }}">
                    <img src="{{asset('frontend/assets/images/logo.png')}}" alt="EduCore" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-9 m-auto wow fadeInRight">
            <div class="wsus__sign_form_area">
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2>Create Account<span>!</span></h2>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="wsus__login_form_input">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__login_form_input">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__login_form_input">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Enter your password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__login_form_input">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__login_form_input">
                                <button type="submit" class="common_btn">Register</button>
                            </div>
                        </div>
                    </div>
                </form>
                <p class="create_account">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </div>
    <a class="back_btn" href="{{ route('home') }}">Back to Home</a>
</section>
@endsection
