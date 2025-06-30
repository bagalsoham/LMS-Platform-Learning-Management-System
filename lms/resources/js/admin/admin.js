import $ from "jquery";
window.$ = window.jQuery = $;

import { Notyf } from "notyf";
import "notyf/notyf.min.css";

/** Notyf init */
const notyf = new Notyf({
    duration: 8000,
    dismissible: true,
});

/** Read CSRF and base URL from meta tags */
const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
const base_url = document.querySelector('meta[name="base-url"]').getAttribute("content");

document.addEventListener("DOMContentLoaded", function () {
    var el;

    // TomSelect
    if (window.TomSelect) {
        new TomSelect((el = document.getElementById("select-users")), {
            copyClassesToDropdown: false,
            dropdownParent: "body",
            controlInput: "<input>",
            render: {
                item: function (data, escape) {
                    return `<div><span class="dropdown-item-indicator">${data.customProperties || ""}</span>${escape(data.text)}</div>`;
                },
                option: function (data, escape) {
                    return `<div><span class="dropdown-item-indicator">${data.customProperties || ""}</span>${escape(data.text)}</div>`;
                },
            },
        });
    }

    // TinyMCE
    tinymce.init({
        selector: ".editor",
        height: 500,
        menubar: false,
        plugins: [
            "advlist", "autolink", "lists", "link", "charmap", "anchor",
            "searchreplace", "visualblocks", "fullscreen", "insertdatetime",
            "media", "table", "help", "wordcount"
        ],
        toolbar:
            "undo redo | blocks | bold italic backcolor | " +
            "alignleft aligncenter alignright alignjustify | " +
            "bullist numlist outdent indent | removeformat | help",
        content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:16px }",
    });

    $(".select2").select2();
});

/** Delete Item with confirmation */
let delete_url = "";

$(".delete-item").on("click", function (e) {
    e.preventDefault();

    const chapterId = $(this).data("id");
    delete_url = `${base_url}/admin/course-content/${chapterId}/chapter`;

    $("#modal-danger").modal("show");
});

$(".delete-confirm").on("click", function (e) {
    e.preventDefault();

    $.ajax({
        method: "DELETE",
        url: delete_url,
        data: {
            _token: csrf_token,
        },
        beforeSend: function () {
            $(".delete-confirm").text("Deleting...");
        },
        success: function () {
            window.location.reload();
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || "Delete failed.";
            notyf.error(message);
        },
        complete: function () {
            $(".delete-confirm").text("Delete");
        },
    });
});

/** Database Clear with confirmation */
$(".db-clear").on("click", function (e) {
    e.preventDefault();
    delete_url = $(this).attr("href");
    $("#modal-database-clear").modal("show");
});

$(".db-clear-submit").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        method: "DELETE",
        url: `${base_url}/admin/database-clear`,
        data: {
            _token: csrf_token,
        },
        beforeSend: function () {
            $(".db-clear-btn").text("Wiping...");
        },
        success: function () {
            window.location.reload();
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || "Database clear failed.";
            notyf.error(message);
        },
        complete: function () {
            $(".db-clear-btn").text("Delete");
        },
    });
});

/** Certificate Position Save */
$(function () {
    $(".draggable-element").draggable({
        containment: ".certificate-body",
        stop: function (event, ui) {
            const elementId = $(this).attr("id");
            const x = ui.position.left;
            const y = ui.position.top;

            $.ajax({
                method: "POST",
                url: `${base_url}/admin/certificate-item`,
                data: {
                    _token: csrf_token,
                    element_id: elementId,
                    x_position: x,
                    y_position: y,
                },
            });
        },
    });
});

/** Featured Instructor AJAX */
$(function () {
    $(".select_instructor").on("change", function () {
        const id = $(this).val();

        $.ajax({
            method: "GET",
            url: `${base_url}/admin/get-instructor-courses/${id}`,
            beforeSend: function () {
                $(".instructor_courses").empty();
            },
            success: function (data) {
                $.each(data.courses, function (key, value) {
                    $(".instructor_courses").append(`<option value="${value.id}">${value.title}</option>`);
                });
            },
            error: function (xhr) {
                const message = xhr.responseJSON?.error || "Could not load courses.";
                notyf.error(message);
            },
        });
    });
});
