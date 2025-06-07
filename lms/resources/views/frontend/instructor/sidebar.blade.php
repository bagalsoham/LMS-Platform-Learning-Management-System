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
