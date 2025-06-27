<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Chapter Sorting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="" method="POST">
            @csrf
            <ul class="item_list chapter_sortable_list ">
                @foreach ($chapters as $chapter)
                    <li class="" data-course-id="{{ $chapter->course_id }}" data-chapter-id="{{ $chapter->id }}">
                        <div class="chapter-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-video text-primary me-2"></i> <!-- Optional: Add icon if needed -->
                                <span class="fw-bold">{{ $chapter->title }}</span>
                            </div>
                            <a class="dragger text-primary" href="javascript:;">
                                <i class="fas fa-arrows-alt"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </form>
    </div>
</div>

<script>
    var base_url = $(`meta[name="base_url"]`).attr('content');
    var csrf_token = $(`meta[name="csrf_token"]`).attr('content');
    $('.btn-close').on('click', function() {
        window.location.reload();
    })
    /** sort chapter list */
    if ($('.chapter_sortable_list li').length) {
        $('.chapter_sortable_list').sortable({
            items: "li",
            containment: "parent",
            cursor: "move",
            handle: ".dragger",
            forcePlaceholderSize: true,
            update: function(event, ui) {
                let orderIds = $(this).sortable("toArray", {
                    attribute: "data-chapter-id",
                });

                let courseId = ui.item.data("course-id");

                $.ajax({
                    method: 'POST',
                    url: base_url + `/instructor/course-content/${courseId}/sort-chapter`,
                    data: {
                        _token: csrf_token,
                        order_ids: orderIds
                    },
                    success: function(data) {
                        notyf.success('Chapter order updated successfully');
                    },
                    error: function(xhr, status, error) {
                        notyf.error('Error updating chapter order');
                    }
                })

            }
        });
    }
</script>
