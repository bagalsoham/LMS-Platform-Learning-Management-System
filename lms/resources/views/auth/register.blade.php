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
                    <div class="form-container">
                        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-student-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-student" type="button" role="tab" aria-controls="pills-student"
                                    aria-selected="true">Student</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-instructor-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-instructor" type="button" role="tab" aria-controls="pills-instructor"
                                    aria-selected="false">Instructor</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-student" role="tabpanel" aria-labelledby="pills-student-tab">
                                <form method="POST" action="{{ route('register',['type'=>'student']) }}" enctype="multipart/form-data">
                                <h2>Create Account<span>!</span></h2>  
                                @csrf
                                    <input type="hidden" name="role" value="student">
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
                                            <div class="wsus__login_form_input" style="visibility: hidden;">
                                                <label>Document</label>
                                                <input type="file" disabled>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="wsus__login_form_input">
                                                <button type="submit" class="common_btn">Register as Student</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-instructor" role="tabpanel" aria-labelledby="pills-instructor-tab">
                                <form method="POST" action="{{ route('register',['type'=>'instructor']) }}" enctype="multipart/form-data"><!-- encoding type is used when submitting forms that include file uploads -->
                                <h2>Create Account<span>!</span></h2>    
                                @csrf
                                    <input type="hidden" name="role" value="instructor">
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
                                                <label>Document(Certificates)</label>
                                                <input type="file" name="document" placeholder="Document" required>
                                                @error('document')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="wsus__login_form_input">
                                                <button type="submit" class="common_btn">Register as Instructor</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <p class="create_account">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                </div>
            </div>
        </div>
    </section>

    <style>
    .form-container {
        position: relative;
        min-height: 600px;
    }

    .nav-pills {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 1;
        padding: 10px 0;
    }

    .tab-content {
        position: relative;
    }

    .tab-pane {
        position: absolute;
        width: 100%;
    }
    </style>
    @endsection
