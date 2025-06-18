@extends('admin.layouts.master')

@section('title', 'Edit Course Sub Category')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Course Sub Category of ({{ $course_category->name }})</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-sub-category.index', $course_category->id) }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-sub-category.update', ['course_category' => $course_category->id, 'course_sub_category' => $course_sub_category->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($course_sub_category->image)
                                            <x-image-preview src="{{ $course_sub_category->image }}" />
                                        @endif
                                        <x-choose-image name="image" label="Image" />
                                    </div>
                                    <div class="col-md-12">
                                        <x-input name="icon" :value="$course_sub_category->icon" label="Icon"
                                            placeholder="Enter Icon class or name" />
                                            <small><a href="https://tabler.io/icons">You can get the icon classes from tabler icon</a> </small>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <x-input name="name" :value="$course_sub_category->name" label="Name"
                                            placeholder="Enter Sub Category Name" />
                                    </div>
                                    <div class="col-md-3 mt-6">
                                        <x-toggle-switch name="show_at_trending" label="Show at Trending"
                                            :checked="$course_sub_category->show_at_trending == 1" />
                                    </div>
                                    <div class="col-md-3 mt-6">
                                        <x-toggle-switch name="status" label="Active Status"
                                            :checked="$course_sub_category->status == 1" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
