@extends('frontend.layouts.master')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notyf()->error('{{ $error }}');
            </script>
        @endforeach
    @endif

    <!--===========================
                                            BREADCRUMB START
                                        ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <h1>Student Dashboard</h1>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li>Student dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
                                            BREADCRUMB END
                                        ============================-->


    <!--===========================
                                            DASHBOARD OVERVIEW START
                                        ============================-->
    <section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                @include('frontend.student.sidebar')

                <div class="col-xl-9 col-md-8 wow fadeInRight">
                    <div class="wsus__dashboard_contant">
                        <div class="wsus__dashboard_contant_top d-flex flex-wrap justify-content-between">
                            <div class="wsus__dashboard_heading">
                                <h5>Update Your Information</h5>
                                <p>Manage your courses and its update like live, draft and insight.</p>
                            </div>
                        </div>
                        <form action="{{ route('student.profile.update') }}" method="POST"
                            class="wsus__dashboard_profile_update" enctype="multipart/form-data">
                            @csrf
                            <div class="wsus__dashboard_profile wsus__dashboard_profile_avatar">
                                <div class="img">
                                    <img src="{{ asset(auth()->user()->image) }}" alt="profile" class="img-fluid w-100">
                                    <label for="profile_photo">
                                        <img src="{{ asset('frontend/assets/images/dash_camera.png') }}" alt="camera"
                                            class="img-fluid w-100">
                                    </label>
                                    <input type="file" id="profile_photo" name="avatar" hidden="">
                                </div>
                                <div class="text">
                                    <h6>Your avatar</h6>
                                    <p>PNG or JPG no bigger than 400px wide and tall.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Name</label>
                                        <input type="text" placeholder="Enter your full name" name="name"
                                            value="{{ auth()->user()->name }}">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Headline</label>
                                        <input type="text" placeholder="Enter your professional headline" name="headline"
                                            value="{{ auth()->user()->headline }}">
                                        <x-input-error :messages="$errors->get('headline')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Email</label>
                                        <input type="email" placeholder="Enter your email address" name="email"
                                            value="{{ auth()->user()->email }}">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Gender</label>
                                        <select name="gender" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="male" @selected(auth()->user()->gender == 'male')>Male</option>
                                            <option value="female" @selected(auth()->user()->gender == 'female')>Female
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>About Me</label>
                                        <textarea rows="7" placeholder="Tell us about yourself"
                                            name="about">{{ auth()->user()->bio }}</textarea>
                                        <x-input-error :messages="$errors->get('about')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_btn">
                                        <button type="submit" class="common_btn">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="wsus__dashboard_contant">
                        <div class="wsus__dashboard_contant_top d-flex flex-wrap justify-content-between">
                            <div class="wsus__dashboard_heading">
                                <h5>Update Your Password</h5>
                                <p>Add your new password here to update .</p>
                            </div>
                        </div>
                        <form action="{{ route('student.profile.update-password') }}" method="POST"
                            class="wsus__dashboard_profile_update">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Current Password</label>
                                        <input type="password" placeholder="Enter your current password"
                                            name="current_password">
                                        <x-input-error :messages="$errors->get('current_password')"
                                            class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Password</label>
                                        <input type="password" placeholder="Enter your new password" name="password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Confirm Password</label>
                                        <input type="password" placeholder="Confirm your new password"
                                            name="password_confirmation">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_btn">
                                        <button type="submit" class="common_btn">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="wsus__dashboard_contant">
                        <div class="wsus__dashboard_contant_top d-flex flex-wrap justify-content-between">
                            <div class="wsus__dashboard_heading">
                                <h5>Update Your Social Information</h5>
                                <p>Update your links here.</p>
                            </div>
                        </div>
                        <form action="{{ route('student.profile.update-social') }}" method="post"
                            class="wsus__dashboard_profile_update">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Facebook</label>
                                        <input type="url" placeholder="Enter your Facebook profile URL" name="facebook"
                                            value="{{ old('facebook', auth()->user()->facebook) }}">
                                        <x-input-error :messages="$errors->get('facebook')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>X (Twitter)</label>
                                        <input type="url" placeholder="Enter your X (Twitter) profile URL" name="x"
                                            value="{{ old('x', auth()->user()->twitter) }}">
                                        <x-input-error :messages="$errors->get('x')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>LinkedIn</label>
                                        <input type="url" placeholder="Enter your LinkedIn profile URL" name="linkedin"
                                            value="{{ old('linkedin', auth()->user()->linkedin) }}">
                                        <x-input-error :messages="$errors->get('linkedin')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__dashboard_profile_update_info">
                                        <label>Website</label>
                                        <input type="url" placeholder="Enter your personal website URL" name="website"
                                            value="{{ old('website', auth()->user()->website) }}">
                                        <x-input-error :messages="$errors->get('website')" class="mt-2 text-danger" />
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__dashboard_profile_update_btn">
                                        <button type="submit" class="common_btn">Apply Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
                                            DASHBOARD OVERVIEW END
                                        ============================-->
@endsection
