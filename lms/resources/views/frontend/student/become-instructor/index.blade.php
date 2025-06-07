@extends('frontend.layouts.master')

@section('content')


    <!--===========================
        BREADCRUMB START
    ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <h1>Become Instructor</h1>
                            <ul>
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li>Become Instructor</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
        BREADCRUMB END
    ============================-->


    <!--===========================
        DASHBOARD OVERVIEW START
    ============================-->
    <section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                @include('frontend.student.sidebar')
                <div class="col-xl-9 col-md-8 wow fadeInRight">
                    <div class="text-end">
                        <a href="{{ route('student.dashboard') }}" class="common_btn">Back</a>
                    </div>
                    <div class="wsus__dashboard_main">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>Become a Instructor</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('student.become-instructor.update',auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="document">Document</label>
                                        <input type="file" class="form-control @error('document') is-invalid @enderror" name="document" id="document">
                                        @error('document')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="text">
                                        <button type="submit" class="common_btn">Submit Application</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
        DASHBOARD OVERVIEW END
    ============================-->
@endsection
