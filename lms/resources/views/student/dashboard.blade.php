<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Track your learning journey and manage your courses.</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Enrolled Courses</h4>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Assignments Due</h4>
                        <p class="text-3xl font-bold text-yellow-600">0</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Average Grade</h4>
                        <p class="text-3xl font-bold text-green-600">N/A</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Current Courses</h4>
                        <div class="space-y-4">
                            <p class="text-gray-600">No courses enrolled yet.</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Browse Courses
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Assignments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Upcoming Assignments</h4>
                        <div class="space-y-4">
                            <p class="text-gray-600">No upcoming assignments.</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Recent Activity</h4>
                        <div class="space-y-4">
                            <p class="text-gray-600">No recent activity.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <div class="space-y-2">
                            <a href="#" class="block text-blue-600 hover:text-blue-800">View All Courses</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">My Assignments</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Course Calendar</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Discussion Forums</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
