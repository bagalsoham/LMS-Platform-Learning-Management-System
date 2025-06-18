@extends('admin.layouts.master')

@section('title', 'Course Languages')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Languages</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.course-languages.create') }}" class="btn btn-primary">
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
                                    <th>Slag</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($languages as $language)
                                <tr>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.course-languages.edit', $language->id) }}" class="btn-sm btn-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="#" class="text-red delete-item" data-delete-url="{{ route('admin.course-languages.destroy', $language->id) }}">
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
                        {{ $languages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
