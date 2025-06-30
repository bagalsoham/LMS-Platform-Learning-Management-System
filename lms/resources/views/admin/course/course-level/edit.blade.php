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
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-levels.update',$course_level->id) }} " method="POST">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    {{-- Remove duplicate label --}}
                                    <x-input name="name" label="Name" placeholder="Enter Level" :value="$course_level->name" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
