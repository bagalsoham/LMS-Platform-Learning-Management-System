<!-- Modal: Create/Edit Lesson -->
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ isset($lesson) ? 'Edit' : 'Create' }} Lesson</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <form
            action="{{ @$editMode == true ? route('instructor.course-content.update-lesson', $lesson->id) : route('instructor.course-content.store-lesson') }}"
            method="post">
            @csrf
            
            <input type="hidden" name="course_id" value="{{ $courseId }}">
            <input type="hidden" name="chapter_id" value="{{ $chapterId }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ @$lesson?->title }}"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="source">Source</label>
                        <select name="source" id="source" class="form-control storage" required>
                            <option value="">Select Source</option>
                            @foreach (config('course.video_sources', []) as $source => $name)
                                <option @selected(@$lesson->storage == $source) value="{{ $source }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="file_type">File Type</label>
                        <select name="file_type" id="file_type" class="form-control" required>
                            <option value="">Select File Type</option>
                            @foreach (config('course.file_types', []) as $type => $name)
                                <option @selected(@$lesson->file_type == $type) value="{{ $type }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="add_course_basic_info_imput upload_source">
                        <label for="file">Upload File</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="demo_video_file" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose File
                                </a>
                            </span>
                            <input id="demo_video_file" class="form-control source_input" type="text" name="file_path"
                                value="{{ @$lesson?->file_path }}" placeholder="Select file from media manager">
                        </div>
                    </div>

                    <div class="add_course_basic_info_imput external_source d-none">
                        <label for="url">External URL</label>
                        <input type="url" name="url" class="form-control source_input" value="{{ @$lesson?->url }}"
                            placeholder="Enter external URL">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="duration">Duration</label>
                        <input type="text" class="form-control" name="duration" id="duration"
                            value="{{ @$lesson?->duration }}" placeholder="e.g., 10:30 or 10 minutes">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="add_course_more_info_checkbox">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_preview" value="1" id="preview"
                                @checked(@$lesson?->is_preview) style="border: 1px solid black;">
                            <label class="form-check-label" for="preview">Is Preview</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="downloadable" value="1"
                                id="downloadable" @checked(@$lesson?->downloadable) style="border: 1px solid black;">
                            <label class="form-check-label" for="downloadable">Downloadable</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4"
                            placeholder="Enter lesson description">{{ @$lesson?->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group text-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">{{ isset($lesson) ? 'Update' : 'Create' }}
                            Lesson</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#lfm').filemanager('file');
</script>
