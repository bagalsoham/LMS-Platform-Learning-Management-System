@extends('admin.layouts.master')

@section('title', 'Create Course Category')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create Category</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-category.index') }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-category.store') }} " method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-choose-image name="image" label="Image" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-input name="icon" label="Icon" placeholder="Enter Icon class or name" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-input name="name" label="Name" placeholder="Enter Category Name" />
                                    </div>
                                    <div class="col-md-3">
                                        <x-toggle-switch name="show_at_trending" label="Show at Trending" />
                                    </div>
                                    <div class="col-md-3">
                                        <x-toggle-switch name="status" label="Active Status" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary " type="submit">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
