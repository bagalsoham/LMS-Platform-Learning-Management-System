@extends('admin.layouts.master')

@section('title', 'Edit Course Language')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Languages</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-languages.index') }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-languages.update',$course_language->id) }} " method="POST">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <x-input name="name" label="Name" placeholder="Enter Language" :value="$course_language->name" />
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
