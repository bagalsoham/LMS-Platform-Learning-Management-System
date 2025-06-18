@extends('admin.layouts.master')

@section('title', 'Edit Course Level')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Course Level</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-levels.index') }}" class="btn btn-primary">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M5 12l6 6" />
                                        <path d="M5 12l6 -6" />
                                    </svg>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-levels.update',$course_level->id) }} " method="POST">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ $course_level->name }}" name="name" placeholder="Enter Level">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary " type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
