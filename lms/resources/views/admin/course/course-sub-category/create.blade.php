@extends('admin.layouts.master')

@section('title', 'Create Course Sub Category')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create Sub Category for ({{ $course_category->name }})</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-sub-category.index', $course_category->id) }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-sub-category.store', $course_category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-choose-image name="image" label="Image" />
                                    </div>
                                    <div class="col-md-12">
                                        <x-input name="icon" label="Icon" placeholder="Enter Icon class or name (e.g., ti ti-book)" />
                                        <small><a href="https://tabler.io/icons" target="_blank">You can get the icon classes from tabler icons</a></small>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <x-input name="name" label="Name" placeholder="Enter Sub Category Name" />
                                    </div>
                                    <div class="col-md-3 mt-6">
                                        <x-toggle-switch name="show_at_trending" label="Show at Trending" />
                                    </div>
                                    <div class="col-md-3 mt-6">
                                        <x-toggle-switch name="status" label="Active Status" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
