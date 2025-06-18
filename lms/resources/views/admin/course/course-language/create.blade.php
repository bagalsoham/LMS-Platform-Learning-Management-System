@extends('admin.layouts.master')

@section('title', 'Create Course Language')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create Languages</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.course-languages.create') }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.course-languages.store') }} " method="POST">
                                @csrf
                                <x-input name="name" label="Name" placeholder="Enter Language" />
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
