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
                                    @if ($category ->show_at_trending ==1)
                                        <span class="badge bg-lime text-lime-fg">Yes</span>
                                    @else
                                        <span class="badge bg-red text-lime-fg">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($category ->status ==1)
                                        <span class="badge bg-lime text-lime-fg">Yes</span>
                                    @else
                                        <span class="badge bg-red text-lime-fg">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.course-category.edit', $category->id) }}" class="btn-sm btn-primary">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    </a>
                                    <a href="#" class="text-red delete-item" data-delete-url="{{ route('admin.course-category.destroy', $category->id) }}">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h16" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>
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
