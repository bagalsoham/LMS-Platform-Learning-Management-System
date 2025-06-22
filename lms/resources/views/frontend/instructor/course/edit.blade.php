@extends('frontend.instructor.course.course-app')

@section('course_content')
<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <div class="add_course_basic_info">
        <form action="{{ route('instructor.course.store-basic-info') }}" method="post" class="basic_info_update_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id" name="current_step" value="{{ $course->id }}">
            <input type="hidden" name="next_step" value="2">

            <div class="row">
                <div class="col-xl-12">
                    <div class="add_course_basic_info_imput">
                        <label>Title *</label>
                        <input type="text" placeholder="Title" name="title" value="{{ $course->title ?? old('title') }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="add_course_basic_info_imput">
                        <label>Seo description</label>
                        <input type="text" placeholder="Seo description" name="seo_description" value="{{ $course->seo_description ?? old('seo_description') }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="add_course_basic_info_imput">
                        <label>Thumbnail *</label>
                        <input type="file" name="thumbnail">
                        @if(isset($course->thumbnail) && $course->thumbnail)
                            <p class="mt-2 text-muted">Current thumbnail: {{ basename($course->thumbnail) }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="add_course_basic_info_imput">
                        <label>Demo Video Storage <b>(optional)</b></label>
                        <select class="select_js storage" name="demo_video_storage">
                            <option value=""> Please Select </option>
                            <option value="upload" {{ (old('demo_video_storage', $course->demo_video_storage) == 'upload') ? 'selected' : '' }}> Upload </option>
                            <option value="youtube" {{ (old('demo_video_storage', $course->demo_video_storage) == 'youtube') ? 'selected' : '' }}> YouTube </option>
                            <option value="vimeo" {{ (old('demo_video_storage', $course->demo_video_storage) == 'vimeo') ? 'selected' : '' }}> Vimeo </option>
                            <option value="external_link" {{ (old('demo_video_storage', $course->demo_video_storage) == 'external_link') ? 'selected' : '' }}> External Link </option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="add_course_basic_info_imput upload_source {{ $course->demo_video_storage == 'upload' ? '' : 'd-none' }}">
                        <label>Path</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="demo_video_file" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="demo_video_file" class="form-control source_input" type="text" name="demo_video_source" value="{{ $course->demo_video_source }}">
                        </div>
                    </div>

                    <div class="add_course_basic_info_imput external_source {{ $course->demo_video_storage != 'upload' ? '' : 'd-none' }}">
                        <label>Path</label>
                        <input type="text" name="demo_video_source" class="source_input" value="{{ $course->demo_video_source }}">
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="add_course_basic_info_imput">
                        <label>Price *</label>
                        <input type="text" placeholder="Price" name="price" value="{{ $course->price ?? old('price') }}">
                        <p>Put 0 for free</p>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="add_course_basic_info_imput">
                        <label>Discount Price</label>
                        <input type="text" placeholder="Discount Price" name="discount" value="{{ $course->discount ?? old('discount') }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="add_course_basic_info_imput mb-0">
                        <label>Description</label>
                        <textarea rows="8" placeholder="Description" name="description">{{ $course->description ?? old('description') }}</textarea>
                        <button type="submit" class="common_btn mt_20">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lfm').filemanager('file');

    // Toggle input visibility based on storage selection
    $('.storage').on('change', function () {
        const value = $(this).val();
        if (value === 'upload') {
            $('.upload_source').removeClass('d-none');
            $('.external_source').addClass('d-none');
        } else {
            $('.external_source').removeClass('d-none');
            $('.upload_source').addClass('d-none');
        }
    });
</script>
@endpush
