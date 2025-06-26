const csrf_token = $(`meta[name="csrf_token"]`).attr("content");
const base_url = $(`meta[name="base_url"]`).attr("content");
const basic_info_url = base_url + "/instructor/courses/create";
// Remove the old update_url since we'll build it dynamically

var loader = `
<div class="modal-content text-center" style="height: 100px; display: flex; align-items: center; justify-content: center;">
<div class="spinner-border" role="status">
  <span class="sr-only">Loading...</span>
</div></div>
`;

//course tab navigation
$(".course-tab").on("click", function (e) {
    e.preventDefault();
    let step = $(this).data("step");
    $(".course-form").find("input[name=next_step]").val(step);
    $(".course-form").trigger("submit");
});

$(".basic_info_form").on("submit", function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = new FormData(this);
    let url = form.attr("action"); // Use the form's action attribute
    $.ajax({
        method: "POST",
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {},
        success: function (data) {
            if (data.status == "success") {
                window.location.href = data.redirect;
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            });
        },
        complete: function () {},
    });
});

$(".basic_info_update_form").on("submit", function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = new FormData(this);
    let url = form.attr("action");

    // Build URL if action is empty
    if (!url) {
        let courseId = form.find('input[name="id"]').val();
        url = base_url + "/instructor/courses/" + courseId + "/update";
    }

    $.ajax({
        method: "POST",
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {},
        success: function (data) {
            if (data.status == "success") {
                window.location.href = data.redirect;
            }
        },
        error: function (xhr, status, error) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            });
        },
        complete: function () {},
    });
});

$(".more_info_form").on("submit", function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = new FormData(this);
    let url = form.attr("action");

    // Build URL if action is empty - this is the KEY FIX
    if (!url) {
        let courseId = form.find('input[name="id"]').val();
        url = base_url + "/instructor/courses/" + courseId + "/update";
    }

    $.ajax({
        method: "POST",
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {},
        success: function (data) {
            if (data.status == "success") {
                window.location.href = data.redirect;
            }
        },
        error: function (xhr, status, error) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                notyf.error(value[0]);
            });
        },
        complete: function () {},
    });
});

$(document).ready(function () {
    // show hide path input depending on source
    $(document).on("change", ".storage", function () {
        let value = $(this).val();
        $(".source_input").val("");
        console.log("working");
        if (value == "upload") {
            $(".upload_source").removeClass("d-none");
            $(".external_source").addClass("d-none");
        } else {
            $(".upload_source").addClass("d-none");
            $(".external_source").removeClass("d-none");
        }
    });
});

$(document).on("click", ".dynamic-modal-btn", function (e) {
    e.preventDefault();
    $("#dynamic-modal").modal("show");
    let course_id = $(this).data('id');

    $.ajax({
        method: "GET",
        url: base_url + "/instructor/course-content/" + course_id + "/create-chapter",
        dataType: "html",
        beforeSend: function () {
            $(".dynamic-modal-content").html(loader);
        },
        success: function (data) {
            $(".dynamic-modal-content").html(data);
        },
        error: function (xhr, status, error) {},
    });
});

$(document).on("click", ".edit_chapter", function (e) {
    e.preventDefault();
    $("#dynamic-modal").modal("show");
    let chapter_id = $(this).data('chapter-id'); // <-- FIXED

    $.ajax({
        method: "GET",
        url: base_url + "/instructor/course-content/" + chapter_id + "/edit-chapter",
        dataType: "html",
        beforeSend: function () {
            $(".dynamic-modal-content").html(loader);
        },
        success: function (data) {
            $(".dynamic-modal-content").html(data);
        },
        error: function (xhr, status, error) {},
    });
});

$('.add_lesson').on('click', function (e) {
    e.preventDefault();
    $("#dynamic-modal").modal("show");

    let courseId = $(this).data('course-id');
    let chapterId = $(this).data('chapter-id');
    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/create-lesson',
        data: {  // ← Changed from 'dataType' to 'data'
            'course_id': courseId,
            'chapter_id': chapterId
        },
        dataType: 'html',  // ← Added proper dataType (since you're loading HTML into modal)
        beforeSend: function () {
            $(".dynamic-modal-content").html(loader);
        },
        success: function (data) {
            $(".dynamic-modal-content").html(data);
        },
        error: function (xhr, status, error) {
            console.error('Error loading lesson form:', error);
            $(".dynamic-modal-content").html('<p>Error loading form. Please try again.</p>');
        }
    });
});

$('.edit_lesson').on('click', function (e) {
    e.preventDefault();
    $("#dynamic-modal").modal("show");

    let courseId = $(this).data('course-id');
    let chapterId = $(this).data('chapter-id');
    let lessonId = $(this).data('lesson-id'); // Assuming you have a lesson ID to edit
    $.ajax({
        method: 'GET',
        url: base_url + '/instructor/course-content/edit-lesson',
        data: {  // ← Changed from 'dataType' to 'data'
            'course_id': courseId,
            'chapter_id': chapterId,
            'lesson_id': lessonId // Pass the lesson ID for editing
        },
        dataType: 'html',  // ← Added proper dataType (since you're loading HTML into modal)
        beforeSend: function () {
            $(".dynamic-modal-content").html(loader);
        },
        success: function (data) {
            $(".dynamic-modal-content").html(data);
        },
        error: function (xhr, status, error) {
            console.error('Error loading lesson form:', error);
            $(".dynamic-modal-content").html('<p>Error loading form. Please try again.</p>');
        }
    });
});




