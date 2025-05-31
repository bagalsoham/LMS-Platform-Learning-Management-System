@extends('frontend.layouts.master')

@section('content')
<section class="wsus__sign_in wsus__sign_in">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-6 col-lg-6 wow fadeInLeft">
                <div class="wsus__sign_img">
                    <img src="{{asset('frontend/assets/images/login_img_1.jpg')}}" alt="login" class="img-fluid">
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

                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <h2>Log in<span>!</span></h2>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_form_input">
                                            <label>Email</label>
                                            <input type="email" placeholder="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_form_input">
                                            <label>Password<a href="{{ route('password.request') }}">Forgot Password?</a></label>
                                            <input type="password" name="password" placeholder="Password" required>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_form_input">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="1"
                                                    id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Remember Me
                                                </label>
                                            </div>
                                            <button type="submit" class="common_btn">Sign In</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="or">or</p>
                            <p class="create_account">Don't have an account? <a href="{{ route('register') }}">Create free
                                    account</a></p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <a class="back_btn" href="{{ route('home') }}">Back to Home</a>
    </section>
@endsection
