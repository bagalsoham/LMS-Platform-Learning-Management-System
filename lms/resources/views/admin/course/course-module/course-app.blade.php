@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Create</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.course.index') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dashboard_add_courses">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation ">
                                <a href="javascript:void(0);" class="nav-link course-tab {{ request('step') == 1 ? 'active' : '' }}"
                                    data-step="1">Basic Infos</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0);" class="nav-link course-tab {{ request('step') == 2 ? 'active' : '' }}"
                                    data-step="2">More Info</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0);" class="nav-link course-tab {{ request('step') == 3 ? 'active' : '' }}"
                                    data-step="3">Course Contents</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0);" class="nav-link course-tab {{ request('step') == 4 ? 'active' : '' }}"
                                    data-step="4">Finish</a>
                            </li>
                        </ul>
                        @yield('tab_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        if (typeof $.fn.filemanager === 'function') {
            $('#lfm').filemanager('file', { prefix: '/admin/laravel-filemanager' });
        } else {
            console.error('Laravel File Manager script not loaded or jQuery missing.');
        }
    });
</script>
@endpush

@push('header_scripts')
    @vite(['resources/js/admin/course.js'])
@endpush
