/** const variables */
console.log("working admin course js");

// jQuery is already loaded globally, no need to import
const $ = window.jQuery;

// Get CSRF and base URL from meta tags or window globals
const csrf_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || window.csrf_token;
const base_url = document.querySelector('meta[name="base-url"]')?.getAttribute("content") || window.base_url;

// Validate required variables
if (!csrf_token || !base_url) {
    console.error('Missing required CSRF token or base URL');
}

const basic_info_url = base_url + '/admin/courses/create';
const update_url = (id) => base_url + '/admin/courses/' + id + '/update';

// Use global notyf if available, otherwise create new instance
let notyf;
if (window.notyf) {
    notyf = window.notyf;
} else {
    // Import Notyf if not available globally
    import("notyf").then(({ Notyf }) => {
        notyf = new Notyf({
            duration: 5000,
            dismissible: true
        });
    });
}

const loader = `
<div class="modal-content text-center p-3" style="display:inline">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
`;

/** reusable functions */
function updateApproveStatus(id, status) {
    console.log("working");

    $.ajax({
        method: 'PUT',
        url: base_url + `/admin/courses/${id}/update-approval`,
        data: {
            _token: csrf_token,
            status: status
        },
        success: function (data) {
            window.location.reload();
        },
        error: function (xhr, status, error) {
            console.error('Error updating approval status:', error);
        }
    });
}

/** on dom load */
$(function () {
    /** change course approval status */
    $(document).on('change', '.update-approval-status', function () {
        let id = $(this).data('id');
        let status = $(this).val();

        updateApproveStatus(id, status);
    });

    //course tab navigation
    $(document).on('click', '.course-tab', function (e) {
        e.preventDefault();
        let step = $(this).data('step');
        $('.course-form').find('input[name=next_step]').val(step);
        $('.course-form').trigger('submit');
    });

    $(document).on('submit', '.basic_info_form', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
            method: "POST",
            url: basic_info_url,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Add loading state if needed
            },
            success: function (data) {
                if (data.status == 'success') {
                    window.location.href = data.redirect;
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                let errors = xhr.responseJSON?.errors || {};
                $.each(errors, function (key, value) {
                    notyf.error(value[0]);
                });
            },
            complete: function () {
                // Remove loading state if needed
            }
        });
    });

    $(document).on('submit', '.basic_info_update_form', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let courseId = formData.get('id');
        $.ajax({
            method: "POST",
            url: update_url(courseId),
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Add loading state if needed
            },
            success: function (data) {
                if (data.status == 'success') {
                    window.location.href = data.redirect;
                }
            },
            error: function (xhr, status, error) {
                let errors = xhr.responseJSON?.errors || {};
                $.each(errors, function (key, value) {
                    notyf.error(value[0]);
                });
            },
            complete: function () {
                // Remove loading state if needed
            }
        });
    });

    $(document).on('submit', '.more_info_form', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let courseId = formData.get('id');
        $.ajax({
            method: "POST",
            url: update_url(courseId),
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Add loading state if needed
            },
            success: function (data) {
                if (data.status == 'success') {
                    window.location.href = data.redirect;
                }
            },
            error: function (xhr, status, error) {
                let errors = xhr.responseJSON?.errors || {};
                $.each(errors, function (key, value) {
                    notyf.error(value[0]);
                });
            },
            complete: function () {
                // Remove loading state if needed
            }
        });
    });

    // show hide path input depending on source
    $(document).on('change', '.storage', function () {
        let value = $(this).val();
        $('.source_input').val('');
        console.log("working");
        if (value == 'upload') {
            $('.upload_source').removeClass('d-none');
            $('.external_source').addClass('d-none');
        } else {
            $('.upload_source').addClass('d-none');
            $('.external_source').removeClass('d-none');
        }
    });

    /** Course Contents */
    $(document).on('click', '.dynamic-modal-btn', function (e) {
        e.preventDefault();
        $('#dynamic-modal').modal("show");

        let course_id = $(this).data('id');

        $.ajax({
            method: 'GET',
            url: base_url + '/admin/course-content/:id/create-chapter'.replace(':id', course_id),
            data: {},
            beforeSend: function () {
                $('.dynamic-modal-content').html(loader);
            },
            success: function (data) {
                $('.dynamic-modal-content').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error loading chapter form:', error);
            }
        });
    });

    $(document).on('click', '.edit_chapter', function (e) {
        e.preventDefault();
        $('#dynamic-modal').modal("show");

        let chapter_id = $(this).data('chapter-id');

        $.ajax({
            method: 'GET',
            url: base_url + '/admin/course-content/:id/edit-chapter'.replace(':id', chapter_id),
            data: {},
            beforeSend: function () {
                $('.dynamic-modal-content').html(loader);
            },
            success: function (data) {
                $('.dynamic-modal-content').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error loading chapter edit form:', error);
            }
        });
    });

    $(document).on('click', '.add_lesson', function (e) {
        e.preventDefault();
        $('#dynamic-modal').modal("show");

        let courseId = $(this).data('course-id');
        let chapterId = $(this).data('chapter-id');
        let url = window.location.origin + '/admin/course-content/create-lesson';

        $.ajax({
            method: 'GET',
            url: url,
            data: {
                'course_id': courseId,
                'chapter_id': chapterId
            },
            beforeSend: function () {
                $('.dynamic-modal-content').html(loader);
            },
            success: function (data) {
                $('.dynamic-modal-content').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error loading lesson form:', error);
            }
        });
    });

    $(document).on('click', '.edit_lesson', function () {
        $('#dynamic-modal').modal("show");

        let courseId = $(this).data('course-id');
        let chapterId = $(this).data('chapter-id');
        let lessonId = $(this).data('lesson-id');

        $.ajax({
            method: 'GET',
            url: base_url + '/admin/course-content/edit-lesson',
            data: {
                'course_id': courseId,
                'chapter_id': chapterId,
                'lesson_id': lessonId
            },
            beforeSend: function () {
                $('.dynamic-modal-content').html(loader);
            },
            success: function (data) {
                $('.dynamic-modal-content').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error loading lesson edit form:', error);
            }
        });
    });

    // Initialize sortable functionality
    function initializeSortable() {
        if ($('.sortable_list li').length && $.fn.sortable) {
            $('.sortable_list').sortable({
                items: "li",
                containment: "parent",
                cursor: "move",
                handle: ".dragger",
                update: function (event, ui) {
                    let orderIds = $(this).sortable("toArray", {
                        attribute: "data-lesson-id",
                    });

                    let chapterId = ui.item.data("chapter-id");

                    $.ajax({
                        method: 'POST',
                        url: base_url + `/admin/course-chapter/${chapterId}/sort-lesson`,
                        data: {
                            _token: csrf_token,
                            order_ids: orderIds
                        },
                        success: function (data) {
                            notyf.success(data.message);
                        },
                        error: function (xhr, status, error) {
                            notyf.error(xhr.responseJSON?.error || 'Sorting failed');
                        }
                    });
                }
            });
        }
    }

    // Initialize sortable on page load
    initializeSortable();

    // Reinitialize sortable after dynamic content is loaded
    $(document).on('shown.bs.modal', '#dynamic-modal', function () {
        setTimeout(initializeSortable, 100);
    });

    $(document).on('click', '.sort_chapter_btn', function () {
        $('#dynamic-modal').modal("show");
        let courseId = $(this).data('id');
        $.ajax({
            method: 'GET',
            url: base_url + `/admin/course-content/${courseId}/sort-chapter`,
            data: {},
            beforeSend: function () {
                $('.dynamic-modal-content').html(loader);
            },
            success: function (data) {
                $('.dynamic-modal-content').html(data);
            },
            error: function (xhr, status, error) {
                notyf.error(xhr.responseJSON?.error || 'Failed to load chapter sorting');
            }
        });
    });
});

// Force reinitialize dropdowns after all assets are loaded
window.addEventListener('load', function() {
    setTimeout(() => {
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
            if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                new bootstrap.Dropdown(element);
            }
        });
    }, 500);
});
