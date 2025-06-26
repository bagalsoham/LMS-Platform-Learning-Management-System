<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            {{ !empty($editMode) ? 'Edit Chapter' : 'Create Chapter' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{ !empty($editMode)
            ? route('instructor.course-content.update-chapter', $chapter->id)
            : (isset($id) ? route('instructor.course-content.store-chapter', $id) : '#')
        }}" method="post">
            @csrf
            @if (!empty($editMode))
                @method('PUT')
            @endif
            <div class="form-group mb-3">
                <label for="">Title</label>
                <input type="text" class="form-control" name="title" required value="{{ $chapter->title ?? '' }}">
            </div>
            <div class="form-group text-end">
                <button type="submit" class="btn btn-primary">
                    {{ !empty($editMode) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
