@extends('admin.layouts.master')

@section('title', 'Course Levels')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Levels</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.course-levels.create') }}" class="btn btn-primary">
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
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($levels as $level)
                                <tr>
                                <td>{{ $level->name }}</td>
                                <td>{{ $level->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.course-levels.edit', $level->id) }}" class="btn-sm btn-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="#" class="text-red delete-item" data-delete-url="{{ route('admin.course-levels.destroy', $level->id) }}">
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
                        {{ $levels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
