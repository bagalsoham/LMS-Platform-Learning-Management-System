const csrf_token = $(`meta[name="csrf_token"]`).attr('content');
const base_url = $(`meta[name="base_url"]`).attr('content');
const basic_info_url = base_url + '/instructor/courses/create';
const update_url = base_url + '/instructor/courses/update';

// Get course ID from URL if available
const courseId = window.location.pathname.split('/')[3];
const basic_info_update_url = courseId ? base_url + '/instructor/courses/' + courseId + '/update' : update_url;
const more_info_url = courseId ? base_url + '/instructor/courses/' + courseId + '/update' : update_url;

var notyf = new Notyf({
    duration: 5000,
    dismissible: true
});

var loader = `
<div class="modal-content text-center p-3" style="display:inline">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
`;

// Debug function to log important information
function debugLog(message, data = null) {
    console.log(`[DEBUG] ${message}`, data || '');
}

// Enhanced error parsing with more detailed logging
function parseErrorResponse(xhr) {
    debugLog('Parsing error response', {
        status: xhr.status,
        statusText: xhr.statusText,
        responseText: xhr.responseText
    });

    let errorMessage = 'An unexpected error occurred. Please try again.';

    try {
        const response = JSON.parse(xhr.responseText);
        debugLog('Parsed JSON response', response);

        if (response.message) {
            errorMessage = response.message;
        } else if (response.errors) {
            // Handle Laravel validation errors
            const errors = [];
            for (let field in response.errors) {
                if (Array.isArray(response.errors[field])) {
                    errors.push(...response.errors[field]);
                } else {
                    errors.push(response.errors[field]);
                }
            }
            errorMessage = errors.length > 0 ? errors.join('<br>') : errorMessage;
        } else if (response.error) {
            errorMessage = response.error;
        }
    } catch (e) {
        debugLog('JSON parsing failed, using status code', e);

        // If JSON parsing fails, check for common HTTP status codes
        switch (xhr.status) {
            case 400:
                errorMessage = 'Bad request. Please check your input and try again.';
                break;
            case 401:
                errorMessage = 'You are not authorized to perform this action. Please log in and try again.';
                break;
            case 403:
                errorMessage = 'You do not have permission to perform this action.';
                break;
            case 404:
                errorMessage = 'The requested resource was not found.';
                break;
            case 422:
                errorMessage = 'Validation failed. Please check your input and try again.';
                break;
            case 429:
                errorMessage = 'Too many requests. Please wait a moment and try again.';
                break;
            case 500:
                errorMessage = 'Server error. Please try again later or contact support.';
                break;
            case 503:
                errorMessage = 'Service temporarily unavailable. Please try again later.';
                break;
            default:
                if (xhr.status >= 400 && xhr.status < 500) {
                    errorMessage = 'Client error occurred. Please check your request and try again.';
                } else if (xhr.status >= 500) {
                    errorMessage = 'Server error occurred. Please try again later.';
                }
        }
    }

    debugLog('Final error message', errorMessage);
    return errorMessage;
}

// Utility function to show error messages with both notyf and custom alerts
function showError(message, duration = 5000) {
    // Use notyf for primary error display
    notyf.error(message);

    // Also show custom alert for critical errors
    $('.error-message').remove();
    const errorHtml = `
        <div class="error-message alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <strong>Error:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('body').append(errorHtml);

    setTimeout(() => {
        $('.error-message').fadeOut(() => {
            $('.error-message').remove();
        });
    }, duration);
}

// Utility function to show success messages
function showSuccess(message, duration = 3000) {
    notyf.success(message);

    $('.success-message').remove();
    const successHtml = `
        <div class="success-message alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <strong>Success:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('body').append(successHtml);

    setTimeout(() => {
        $('.success-message').fadeOut(() => {
            $('.success-message').remove();
        });
    }, duration);
}

// Utility function to disable/enable form
function toggleFormState(form, disabled) {
    const $form = $(form);
    const $submitBtn = $form.find('button[type="submit"], input[type="submit"]');
    const $inputs = $form.find('input, select, textarea');

    if (disabled) {
        $submitBtn.prop('disabled', true).addClass('loading');
        $inputs.prop('readonly', true);
        $form.addClass('form-disabled');

        const originalText = $submitBtn.text();
        $submitBtn.data('original-text', originalText)
                  .html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...');
    } else {
        $submitBtn.prop('disabled', false).removeClass('loading');
        $inputs.prop('readonly', false);
        $form.removeClass('form-disabled');

        const originalText = $submitBtn.data('original-text');
        if (originalText) {
            $submitBtn.html(originalText);
        }
    }
}

//course tab navigation
$('.course-tab').on('click', function (e) {
    e.preventDefault();
    let step = $(this).data('step');
    $('.course-form').find('input[name=next_step]').val(step);
    $('.course-form').trigger('submit');
});

// Enhanced basic info form handler
$('.basic_info_form').on('submit', function (e) {
    e.preventDefault();

    const $form = $(this);
    let formData = new FormData(this);

    debugLog('Basic info form submission', {
        url: basic_info_url,
        formData: Object.fromEntries(formData.entries())
    });

    $.ajax({
        method: "POST",
        url: basic_info_url,
        data: formData,
        contentType: false,
        processData: false,
        timeout: 30000,
        beforeSend: function () {
            debugLog('Sending basic info request...');
            toggleFormState($form, true);
        },
        success: function (data) {
            debugLog('Basic info success response', data);

            if (data.status == 'success') {
                showSuccess(data.message || 'Basic information saved successfully!');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showError(data.message || 'Failed to save basic information. Please try again.');
            }
        },
        error: function (xhr, status, error) {
            debugLog('Basic info error', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error,
                ajaxStatus: status
            });

            let errorMessage;

            if (status === 'timeout') {
                errorMessage = 'Request timed out. Please check your connection and try again.';
            } else if (status === 'abort') {
                errorMessage = 'Request was cancelled. Please try again.';
            } else if (xhr.status === 0) {
                errorMessage = 'Network error. Please check your internet connection.';
            } else {
                errorMessage = parseErrorResponse(xhr);
            }

            showError(errorMessage);
        },
        complete: function () {
            debugLog('Basic info request completed');
            toggleFormState($form, false);
        }
    });
});

// Enhanced basic info update form handler
$('.basic_info_update_form').on('submit', function (e) {
    e.preventDefault();

    const $form = $(this);
    let formData = new FormData(this);

    // Check if courseId exists for update operations
    if (courseId && courseId !== 'undefined') {
        formData.append('step', '1');
        debugLog('Using course-specific update URL', { courseId, url: basic_info_update_url });
    }

    debugLog('Basic info update form submission', {
        url: courseId ? basic_info_update_url : update_url,
        courseId: courseId,
        formData: Object.fromEntries(formData.entries())
    });

    $.ajax({
        method: "POST",
        url: courseId ? basic_info_update_url : update_url,
        data: formData,
        contentType: false,
        processData: false,
        timeout: 30000,
        beforeSend: function (xhr) {
            // Add CSRF token if available
            const token = $('meta[name="csrf-token"]').attr('content');
            if (token) {
                xhr.setRequestHeader('X-CSRF-TOKEN', token);
                debugLog('CSRF token added', token);
            }

            debugLog('Sending basic info update request...');
            toggleFormState($form, true);
        },
        success: function (data) {
            debugLog('Basic info update success response', data);

            if (data.status == 'success') {
                showSuccess(data.message || 'Basic information updated successfully!');

                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            } else {
                showError(data.message || 'Failed to update basic information. Please try again.');
            }
        },
        error: function (xhr, status, error) {
            debugLog('Basic info update error', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error,
                ajaxStatus: status
            });

            let errorMessage;

            if (status === 'timeout') {
                errorMessage = 'Request timed out. Please check your connection and try again.';
            } else if (status === 'abort') {
                errorMessage = 'Request was cancelled. Please try again.';
            } else if (xhr.status === 0) {
                errorMessage = 'Network error. Please check your internet connection.';
            } else {
                errorMessage = parseErrorResponse(xhr);
            }

            showError(errorMessage);
        },
        complete: function () {
            debugLog('Basic info update request completed');
            toggleFormState($form, false);
        }
    });
});

// Enhanced more info form handler
$('.more_info_form').on('submit', function (e) {
    e.preventDefault();

    const $form = $(this);
    let formData = new FormData(this);

    // Add step parameter for course updates
    if (courseId && courseId !== 'undefined') {
        formData.append('step', '2');
    }

    debugLog('More info form submission', {
        url: courseId ? more_info_url : update_url,
        courseId: courseId,
        formData: Object.fromEntries(formData.entries())
    });

    $.ajax({
        method: "POST",
        url: courseId ? more_info_url : update_url,
        data: formData,
        contentType: false,
        processData: false,
        timeout: 30000,
        beforeSend: function (xhr) {
            const token = $('meta[name="csrf-token"]').attr('content');
            if (token) {
                xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }

            debugLog('Sending more info request...');
            toggleFormState($form, true);
        },
        success: function (data) {
            debugLog('More info success response', data);

            if (data.status == 'success') {
                showSuccess(data.message || 'Course information updated successfully!');

                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            } else {
                showError(data.message || 'Failed to save course information. Please try again.');
            }
        },
        error: function (xhr, status, error) {
            debugLog('More info error', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error,
                ajaxStatus: status
            });

            let errorMessage;

            if (status === 'timeout') {
                errorMessage = 'Request timed out. Please check your connection and try again.';
            } else if (status === 'abort') {
                errorMessage = 'Request was cancelled. Please try again.';
            } else if (xhr.status === 0) {
                errorMessage = 'Network error. Please check your internet connection.';
            } else {
                errorMessage = parseErrorResponse(xhr);
            }

            showError(errorMessage);
        },
        complete: function () {
            debugLog('More info request completed');
            toggleFormState($form, false);
        }
    });
});

// Enhanced form validation
$('.basic_info_form, .basic_info_update_form, .more_info_form').on('submit', function(e) {
    const $form = $(this);
    const requiredFields = $form.find('[required]');
    let hasErrors = false;

    debugLog('Form validation started', {
        formClass: $form.attr('class'),
        requiredFieldsCount: requiredFields.length
    });

    $form.find('.field-error').removeClass('field-error');
    $form.find('.validation-error').remove();

    requiredFields.each(function() {
        const $field = $(this);
        const value = $field.val().trim();

        if (!value) {
            hasErrors = true;
            $field.addClass('field-error');

            const fieldName = $field.attr('name') || $field.attr('id') || 'This field';
            const errorMsg = `<div class="validation-error text-danger small mt-1">${fieldName} is required.</div>`;
            $field.after(errorMsg);

            debugLog('Validation error', {
                field: fieldName,
                value: value
            });
        }
    });

    if (hasErrors) {
        e.preventDefault();
        e.stopImmediatePropagation();
        showError('Please fill in all required fields.');
        debugLog('Form submission prevented due to validation errors');
        return false;
    }

    debugLog('Form validation passed');
});

$(document).ready(function () {
    // Debug information on page load
    debugLog('Page loaded', {
        base_url: base_url,
        courseId: courseId,
        basic_info_url: basic_info_url,
        basic_info_update_url: basic_info_update_url,
        more_info_url: more_info_url,
        update_url: update_url,
        pathname: window.location.pathname,
        hasCSRFToken: !!$('meta[name="csrf-token"]').attr('content')
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
});

/** Course Contents */

$('.dynamic-modal-btn').on('click', function (e) {
    e.preventDefault();
    $('#dynamic-modal').modal("show");

    let course_id = $(this).data('id');

    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/:id/create-chapter'.replace(':id', course_id),
        data: {},
        beforeSend: function () {
            $('.dynamic-modal-content').html(loader);
        },
        success: function (data) {
            $('.dynamic-modal-content').html(data);
        },
        error: function (xhr, status, error) {
            const errorMessage = parseErrorResponse(xhr);
            showError(errorMessage);
        }
    });
});

$('.edit_chapter').on('click', function (e) {
    e.preventDefault();
    $('#dynamic-modal').modal("show");

    let chapter_id = $(this).data('chapter-id');

    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/:id/edit-chapter'.replace(':id', chapter_id),
        data: {},
        beforeSend: function () {
            $('.dynamic-modal-content').html(loader);
        },
        success: function (data) {
            $('.dynamic-modal-content').html(data);
        },
        error: function (xhr, status, error) {
            const errorMessage = parseErrorResponse(xhr);
            showError(errorMessage);
        }
    });
});

$('.add_lesson').on('click', function() {
    $('#dynamic-modal').modal("show");

    let courseId = $(this).data('course-id');
    let chapterId = $(this).data('chapter-id');

    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/create-lesson',
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
            const errorMessage = parseErrorResponse(xhr);
            showError(errorMessage);
        }
    });
});

$('.edit_lesson').on('click', function() {
    $('#dynamic-modal').modal("show");

    let courseId = $(this).data('course-id');
    let chapterId = $(this).data('chapter-id');
    let lessonId = $(this).data('lesson-id');

    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/edit-lesson',
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
            const errorMessage = parseErrorResponse(xhr);
            showError(errorMessage);
        }
    });
});

if($('.sortable_list li').length) {
    $('.sortable_list').sortable({
        items: "li",
        containment: "parent",
        cursor: "move",
        handle: ".dragger",
        update: function(event, ui) {
            let orderIds = $(this).sortable("toArray", {
                attribute: "data-lesson-id",
            });

            let chapterId = ui.item.data("chapter-id");

            $.ajax({
                method: 'POST',
                url: base_url + `/instructor/course-chapter/${chapterId}/sort-lesson`,
                data: {
                    _token: csrf_token,
                    order_ids: orderIds
                },
                success: function(data) {
                    showSuccess(data.message || 'Lesson order updated successfully!');
                },
                error: function(xhr, status, error) {
                    const errorMessage = parseErrorResponse(xhr);
                    showError(errorMessage);
                }
            });
        }
    });
}

$('.sort_chapter_btn').on('click', function() {
    $('#dynamic-modal').modal("show");
    let courseId = $(this).data('id');

    $.ajax({
        method: 'GET',
        url: base_url + `/instructor/course-content/${courseId}/sort-chapter`,
        data: {},
        beforeSend: function () {
            $('.dynamic-modal-content').html(loader);
        },
        success: function (data) {
            $('.dynamic-modal-content').html(data);
        },
        error: function (xhr, status, error) {
            const errorMessage = parseErrorResponse(xhr);
            showError(errorMessage);
        }
    });
});

// Add CSS for form states and error styling
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .form-disabled {
            opacity: 0.7;
            pointer-events: none;
        }

        .field-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .validation-error {
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .loading {
            position: relative;
        }

        @media (max-width: 768px) {
            .error-message,
            .success-message {
                position: fixed !important;
                top: 10px !important;
                left: 10px !important;
                right: 10px !important;
                max-width: none !important;
            }
        }
    `)
    .appendTo('head');
