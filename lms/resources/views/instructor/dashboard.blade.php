<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Manage your courses and track student progress.</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Total Courses</h4>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Total Students</h4>
                        <p class="text-3xl font-bold text-green-600">0</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Pending Reviews</h4>
                        <p class="text-3xl font-bold text-yellow-600">0</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Active Students</h4>
                        <p class="text-3xl font-bold text-purple-600">0</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Course Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Course Management</h4>
                        <div class="space-y-4">
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mb-4">
                                Create New Course
                            </a>
                            <div class="space-y-2">
                                <p class="text-gray-600">No courses created yet.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Recent Submissions</h4>
                        <div class="space-y-4">
                            <p class="text-gray-600">No recent submissions to review.</p>
                        </div>
                    </div>
                </div>

                <!-- Student Progress -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Student Progress Overview</h4>
                        <div class="space-y-4">
                            <p class="text-gray-600">No student data available yet.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
                        <div class="space-y-2">
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Create New Course</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">View All Students</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Grade Submissions</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Course Analytics</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-800">Discussion Forums</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
