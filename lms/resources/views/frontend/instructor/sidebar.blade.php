<div class="col-xl-3 col-md-4 wow fadeInLeft">
    <div class="wsus__dashboard_sidebar">
        <div class="wsus__dashboard_sidebar_top">
            <div class="dashboard_banner">
                <img src="{{ asset('frontend/assets/images/single_topic_sidebar_banner.jpg') }}" alt="img" class="img-fluid">
            </div>
            <div class="img">
                <img src="{{ asset(auth()->user()->image) }}" alt="profile" class="img-fluid w-100">
            </div>
            <h4>{{ auth()->user()->name }}</h4>
            <p>{{ auth()->user()->role }}</p>
        </div>
        <ul class="wsus__dashboard_sidebar_menu">
            <li>
                <a href="{{ route('instructor.dashboard') }}" class="{{ sidebarItemActive(['instructor.dashboard']) }}">
                    <i class="ti ti-layout-dashboard me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.profile.index') }}" class="{{ sidebarItemActive(['instructor.profile.index']) }}">
                    <i class="ti ti-user-circle me-2"></i>
                    Instructor Profile
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.course.index') }}" class="{{ sidebarItemActive(['instructor.courses.index']) }}">
                    <i class="ti ti-books me-2"></i>
                    Courses
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.orders.index') }}" class="{{ sidebarItemActive(['instructor.orders.index']) }}">
                    <i class="ti ti-shopping-cart me-2"></i>
                    Orders
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.withdraw.index') }}" class="{{ sidebarItemActive(['instructor.withdraw.index']) }}">
                    <i class="ti ti-cash me-2"></i>
                    Withdrawals
                </a>
            </li>
            <li>
                <a href="javascript:;" onclick="event.preventDefault(); $('#logout').submit();">
                    <i class="ti ti-logout me-2"></i>
                    Sign Out
                </a>
                <form method="POST" id="logout" action="{{ route('logout') }}">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
