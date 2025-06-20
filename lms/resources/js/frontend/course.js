const base_url = $('meta[name="base_url"]').attr('content');
const basic_info_url = base_url + '/instructor/courses/create';
const courseId = window.location.pathname.split('/')[3];
const more_info_url = base_url + '/instructor/courses/' + courseId + '/update';

// Utility function to show error messages
function showError(message, duration = 5000) {
    // Remove existing error messages
    $('.error-message').remove();

    // Create and show error message
    const errorHtml = `
        <div class="error-message alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <strong>Error:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('body').append(errorHtml);

    // Auto-hide after duration
    setTimeout(() => {
        $('.error-message').fadeOut(() => {
            $('.error-message').remove();
        });
    }, duration);
}

// Utility function to show success messages
function showSuccess(message, duration = 3000) {
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

// Utility function to parse error response
function parseErrorResponse(xhr) {
    let errorMessage = 'An unexpected error occurred. Please try again.';

    try {
        const response = JSON.parse(xhr.responseText);

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

    return errorMessage;
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

        // Add loading spinner to submit button
        const originalText = $submitBtn.text();
        $submitBtn.data('original-text', originalText)
                  .html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...');
    } else {
        $submitBtn.prop('disabled', false).removeClass('loading');
        $inputs.prop('readonly', false);
        $form.removeClass('form-disabled');

        // Restore original button text
        const originalText = $submitBtn.data('original-text');
        if (originalText) {
            $submitBtn.html(originalText);
        }
    }
}

// Handle basic info form submission
$('.basic_info_form').on('submit', function(e) {
    e.preventDefault();

    const $form = $(this);
    const formData = new FormData(this);

    console.log('Sending basic info request to:', basic_info_url);

    $.ajax({
        method: "POST",
        url: basic_info_url,
        data: formData,
        contentType: false,
        processData: false,
        timeout: 30000, // 30 second timeout
        beforeSend: function() {
            console.log('Sending basic info request...');
            toggleFormState($form, true);
        },
        success: function(data) {
            console.log('Basic info success:', data);

            if (data.status === 'success') {
                showSuccess(data.message || 'Basic information saved successfully!');

                // Redirect after a short delay to show success message
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showError(data.message || 'Failed to save basic information. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Basic info error:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error
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
        complete: function() {
            console.log('Basic info request completed');
            toggleFormState($form, false);
        }
    });
});

// Handle more info form submission
$('.more_info_form').on('submit', function(e) {
    e.preventDefault();

    const $form = $(this);
    const formData = new FormData(this);

    // Add step parameter to form data
    formData.append('step', '2');

    console.log('Sending more info request to:', more_info_url);

    $.ajax({
        method: "POST",
        url: more_info_url,
        data: formData,
        contentType: false,
        processData: false,
        timeout: 30000, // 30 second timeout
        beforeSend: function() {
            console.log('Sending more info request...');
            toggleFormState($form, true);
        },
        success: function(data) {
            console.log('More info success:', data);

            if (data.status === 'success') {
                showSuccess(data.message || 'Course information updated successfully!');

                // Redirect after a short delay to show success message
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showError(data.message || 'Failed to save course information. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            console.error('More info error:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error
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
        complete: function() {
            console.log('More info request completed');
            toggleFormState($form, false);
        }
    });
});

// Handle form validation before submission
$('.basic_info_form, .more_info_form').on('submit', function(e) {
    const $form = $(this);
    const requiredFields = $form.find('[required]');
    let hasErrors = false;

    // Remove existing validation errors
    $form.find('.field-error').removeClass('field-error');
    $form.find('.validation-error').remove();

    // Check required fields
    requiredFields.each(function() {
        const $field = $(this);
        const value = $field.val().trim();

        if (!value) {
            hasErrors = true;
            $field.addClass('field-error');

            // Add error message
            const fieldName = $field.attr('name') || $field.attr('id') || 'This field';
            const errorMsg = `<div class="validation-error text-danger small mt-1">${fieldName} is required.</div>`;
            $field.after(errorMsg);
        }
    });

    // Prevent submission if there are validation errors
    if (hasErrors) {
        e.preventDefault();
        e.stopImmediatePropagation();
        showError('Please fill in all required fields.');
        return false;
    }
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
