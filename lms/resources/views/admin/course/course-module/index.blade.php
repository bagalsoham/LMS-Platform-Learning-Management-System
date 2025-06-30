    @extends('admin.layouts.master')

    @section('title', 'Course Levels')

    @section('content')
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Course Levels</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.course.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus" style="font-size: 18px;"></i>
                                Add new
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Instructor</th>
                                        <th>Status</th>
                                        <th>Approve</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses as $course)
                                        <tr>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->price }}</td>
                                            <td>{{ $course->instructor->name }}</td>
                                            <td>
                                                @if ($course->is_approved == 'pending')
                                                    <span class="badge bg-warning text-white">Pending</span>
                                                @elseif ($course->is_approved == 'approved')
                                                    <span class="badge bg-success text-white">Approved</span>
                                                @elseif ($course->is_approved == 'rejected')
                                                    <span class="badge bg-danger text-white">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="" id="" class="form-control update-approval-status" data-id="{{ $course->id }}">
                                                    <option value="pending" {{ $course->is_approved == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ $course->is_approved == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ $course->is_approved == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.course-levels.edit', $course->id) }}"
                                                    class="btn-sm btn-primary">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <a href="#" class="text-red delete-item"
                                                    data-delete-url="{{ route('admin.course-levels.destroy', $course->id) }}">
                                                    <i class="ti ti-trash-x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Data Found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $courses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('header_scripts')
    @vite( 'resources/js/admin/course.js')

    @endpush
