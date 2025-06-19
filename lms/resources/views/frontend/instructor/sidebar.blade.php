<div class="col-xl-3 col-md-4 wow fadeInLeft">
    <div class="wsus__dashboard_sidebar">
        <div class="wsus__dashboard_sidebar_top">
            <div class="dashboard_banner">
                <img src="{{ asset('frontend/assets/images/single_topic_sidebar_banner.jpg') }}" alt="banner" class="img-fluid">
            </div>
            <div class="img">
                <img src="{{ asset(auth()->user()->image) }}" alt="profile" class="img-fluid w-100">
            </div>
            <h4>{{ Auth::user()->name }}</h4>
            <p>{{ Auth::user()->role }}</p>
        </div>
        <ul class="wsus__dashboard_sidebar_menu">
            <li>
                <a href="{{ route('instructor.dashboard') }}"
                   class="{{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard ti-icon me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.profile.index') }}"
                   class="{{ request()->routeIs('instructor.profile.index') ? 'active' : '' }}">
                    <i class="ti ti-user-circle ti-icon me-2"></i>
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.course.index') }}"
                   class="{{ request()->routeIs('instructor.course.index') ? 'active' : '' }}">
                    <i class="ti ti-book ti-icon me-2"></i>
                    Course
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="ti ti-logout ti-icon"></i>
                        Sign Out
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>
