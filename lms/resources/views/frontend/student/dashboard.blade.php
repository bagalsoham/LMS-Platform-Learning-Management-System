@extends('frontend.layouts.master')

@section('content')


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
                <div class="col-xl-3 col-md-4 wow fadeInLeft">
                    <div class="wsus__dashboard_sidebar">
                        <div class="wsus__dashboard_sidebar_top">
                            <div class="dashboard_banner">
                                <img src="{{ asset('frontend/assets/images/single_topic_sidebar_banner.jpg') }}" alt="banner" class="img-fluid">
                            </div>
                            <div class="img">
                                <img src="{{ asset('frontend/assets/images/dashboard_profile_img.png') }}" alt="profile" class="img-fluid w-100">
                            </div>
                            <h4>{{ Auth::user()->name }}</h4>
                            <p>{{ Auth::user()->role }}</p>
                        </div>
                        <ul class="wsus__dashboard_sidebar_menu">
                            <li>
                                <a href="{{ route('student.dashboard') }}" class="active">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_8.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_1.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_2.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Courses
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_4.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Reviews
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_5.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Orders
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_6.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Students
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_7.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Payouts
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_8.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Support Tickets
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_10.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Security
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_11.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Social Profile
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_12.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Notifications
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="img">
                                        <img src="{{ asset('frontend/assets/images/dash_icon_13.png') }}" alt="icon" class="img-fluid w-100">
                                    </div>
                                    Profile Privacy
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="img">
                                            <img src="{{ asset('frontend/assets/images/dash_icon_16.png') }}" alt="icon" class="img-fluid w-100">
                                        </div>
                                        Sign Out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    @if(auth()->check() && auth()->user()->approve_status === 'pending')
                        <div class="alert alert-primary d-flex align-items-center mb-4" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill"/>
                            </svg>
                            <div>
                                Hi, {{ auth()->user()->name }}! Your instructor request has been sent to the admin. We will notify you once it's approved.
                            </div>
                        </div>
                    @endif

                    <div class="text-end">
                        <a href ="{{ route('student.become-instructor') }}" class="btn btn-primary ">Become Instructor  </a>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-4 col-sm-6 wow fadeInUp">
                            <div class="wsus__dash_earning">
                                <h6>REVENUE</h6>
                                <h3>$2456.34</h3>
                                <p>Earning this month</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 wow fadeInUp">
                            <div class="wsus__dash_earning">
                                <h6>STUDENTS ENROLLMENTS</h6>
                                <h3>16,450</h3>
                                <p>Progress this month</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 wow fadeInUp">
                            <div class="wsus__dash_earning">
                                <h6>COURSES RATING</h6>
                                <h3>4.70</h3>
                                <p>Rating this month</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--===========================
        DASHBOARD OVERVIEW END
    ============================-->
@endsection
