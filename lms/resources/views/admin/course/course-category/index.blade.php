@extends('admin.layouts.master')

@section('title', 'Course Languages')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Categories</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.course-category.create') }}" class="btn btn-primary">
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
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Trending</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td><i class="{{ $category->icon }}"></i></td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if ($category->show_at_trending == 1)
                                                <span class="badge bg-lime text-lime-fg">Yes</span>
                                            @else
                                                <span class="badge bg-red text-lime-fg">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($category->status == 1)
                                                <span class="badge bg-lime text-lime-fg">Yes</span>
                                            @else
                                                <span class="badge bg-red text-lime-fg">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.course-sub-category.index', $category->id) }}"
                                                class="btn-sm btn-primary text-purple">
                                                <i class="ti ti-list" style="font-size: 18px;"></i>
                                            </a>
                                            <a href="{{ route('admin.course-category.edit', $category->id) }}"
                                                class="btn-sm btn-primary">
                                                <i class="ti ti-edit" style="font-size: 18px;"></i>
                                            </a>
                                            <a href="#" class="text-red delete-item"
                                                data-delete-url="{{ route('admin.course-category.destroy', $category->id) }}">
                                                <i class="ti ti-trash-x" style="font-size: 18px;"></i>
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
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
