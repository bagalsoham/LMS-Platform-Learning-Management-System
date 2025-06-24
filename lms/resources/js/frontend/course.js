const csrf_token = $(`meta[name="csrf_token"]`).attr("content");
const base_url = $(`meta[name="base_url"]`).attr("content");
const basic_info_url = base_url + "/instructor/courses/create";
const update_url = base_url + "/instructor/courses/update";

var notyf = new Notyf({
    duration: 5000,
    dismissible: true,
});

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
    let formData = new FormData(this);
    $.ajax({
        method: "POST",
        url: update_url,
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

    $.ajax({
        method: "GET",
        url: base_url + "/instructor/course-content/create-chapter",
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
