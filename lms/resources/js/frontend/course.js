const csrf_token = $(`meta[name="csrf_token"]`).attr('content');
const base_url = $(`meta[name="base_url"]`).attr('content');
const basic_info_url = base_url + '/instructor/courses/create';
const update_url = base_url + '/instructor/courses/update';

const notyf = new Notyf({
    duration: 5000,
    dismissible: true
});

//course tab navigation
$('.course-tab').on('click', function (e) {
    e.preventDefault();
    let step = $(this).data('step');
    $('.course-form').find('input[name=next_step]').val(step);
    $('.course-form').trigger('submit');
});





$('.basic_info_form').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        method: "POST",
        url: basic_info_url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            if (data.status == 'success') {

                window.location.href = data.redirect
            }
        },
        error: function (xhr, status, error) {
           console.log(xhr);
            let errors = xhr.responseJSON.errors;

            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            });

        },
        complete: function () { }
    })

});

$('.basic_info_update_form').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        method: "POST",
        url: update_url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            if (data.status == 'success') {
                window.location.href = data.redirect
            }
        },
        error: function (xhr, status, error) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            })
        },
        complete: function () { }
    })

});

$('.more_info_form').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        method: "POST",
        url: update_url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            if (data.status == 'success') {

                window.location.href = data.redirect
            }
        },
        error: function (xhr, status, error) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            })
        },
        complete: function () { }
    })

});

//show hide path input depending on source type
/* $('.storage').on('change', function () {
    let value = $(this).val();
    console.log(value);

    if(value == 'upload'){
        $('.upload_source').removeClass('d-none');
        $('.external_source').addClass('d-none');
    } else if(value == '' || value == 'Please Select') {
        // Hide both when no option is selected
        $('.upload_source').addClass('d-none');
        $('.external_source').addClass('d-none');
    } else {
        // Show external source for youtube, vimeo, external_link
        $('.external_source').removeClass('d-none');
        $('.upload_source').addClass('d-none');
    }
}); */

$(document).ready(function() {
    // Initialize Laravel File Manager for video files
    if ($('#video_lfm').length > 0) {
        $('#video_lfm').filemanager('file');
    }

    // Also initialize any other file managers on the page
    if ($('#lfm').length > 0) {
        $('#lfm').filemanager('file');
    }

    // Show/hide path input depending on source type
    $('.storage').on('change', function () {
        let value = $(this).val();
        console.log('Selected storage type:', value);

        if(value == 'upload'){
            $('.upload_source').removeClass('d-none');
            $('.external_source').addClass('d-none');
            // Clear external URL when switching to upload
            $('.external_source input[name="url"]').val('');
        } else if(value == '' || value == 'Please Select') {
            // Hide both when no option is selected
            $('.upload_source').addClass('d-none');
            $('.external_source').addClass('d-none');
        } else {
            // Show external source for youtube, vimeo, external_link
            $('.external_source').removeClass('d-none');
            $('.upload_source').addClass('d-none');
            // Clear file path when switching to external
            $('.upload_source input[name="file"]').val('');
        }
    });

    // Optional: Add validation to ensure the correct input has value
    $('form.course-form').on('submit', function(e) {
        let storageType = $('.storage').val();
        let hasFile = $('#video_path').val().trim() !== '';
        let hasUrl = $('.external_source input[name="url"]').val().trim() !== '';

        if (storageType && storageType !== '' && storageType !== 'Please Select') {
            if (storageType === 'upload' && !hasFile) {
                alert('Please select a video file for upload.');
                e.preventDefault();
                return false;
            } else if (storageType !== 'upload' && !hasUrl) {
                alert('Please enter a video URL.');
                e.preventDefault();
                return false;
            }
        }
    });
});
