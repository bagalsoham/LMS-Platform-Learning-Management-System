@extends('admin.layouts.master')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Instructor Request Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <p class="form-control-plaintext">{{ $instructorRequest->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <p class="form-control-plaintext">{{ $instructorRequest->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <p class="form-control-plaintext">{{ $instructorRequest->role }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <p class="form-control-plaintext">
                                        @if($instructorRequest->approve_status == 'pending')
                                            <span class="badge bg-yellow-lt">Pending</span>
                                        @elseif($instructorRequest->approve_status == 'approved')
                                            <span class="badge bg-green-lt">Approved</span>
                                        @else
                                            <span class="badge bg-red-lt">Rejected</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.instructor-request.index') }}" class="btn btn-primary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 