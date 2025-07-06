console.log("Admin JS Loaded");

// jQuery is already loaded globally, no need to import
// Use the globally available jQuery
const $ = window.jQuery;

import { Notyf } from "notyf";
import "notyf/notyf.min.css";

/** Notyf init */
const notyf = new Notyf({
    duration: 8000,
    dismissible: true,
});

/** Read CSRF and base URL from meta tags */
const csrf_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
const base_url = document.querySelector('meta[name="base-url"]')?.getAttribute("content");

// Make notyf globally available
window.notyf = notyf;

document.addEventListener("DOMContentLoaded", function () {
    var el;

    // TomSelect
    if (window.TomSelect) {
        const selectElement = document.getElementById("select-users");
        if (selectElement) {
            new TomSelect(selectElement, {
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
    }

    // TinyMCE
    if (window.tinymce) {
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
    }

    // Select2 initialization
    if (window.$ && $.fn.select2) {
        $(".select2").select2();
    }
});

/** Delete Item with confirmation */
let delete_url = "";

$(document).on("click", ".delete-item", function (e) {
    e.preventDefault();

    const itemId = $(this).data("id");
    const itemType = $(this).data("type"); // 'chapter', 'lesson', 'gateway', etc.

    if (!itemId || !itemType) {
        notyf.error("No item ID or type found for deletion");
        return;
    }

    // Handle different item types
    if (itemType === "chapter") {
        delete_url = `${base_url}/admin/course-content/${itemId}/chapter`;
    } else if (itemType === "lesson") {
        delete_url = `${base_url}/admin/course-content/${itemId}/lesson`;
    } else if (itemType === "gateway") {
        delete_url = `${base_url}/admin/payout-gateway/${itemId}`;
    } else {
        notyf.error("Unknown item type for deletion");
        return;
    }

    $("#modal-danger").modal("show");
});

$(document).on("click", ".delete-confirm", function (e) {
    e.preventDefault();

    // Check if delete_url is set
    if (!delete_url) {
        notyf.error("No delete URL specified");
        return;
    }

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
            console.error('Delete error:', xhr);
        },
        complete: function () {
            $(".delete-confirm").text("Delete");
        },
    });
});

/** Database Clear with confirmation */
$(document).on("click", ".db-clear", function (e) {
    e.preventDefault();
    delete_url = $(this).attr("href");
    $("#modal-database-clear").modal("show");
});

$(document).on("submit", ".db-clear-submit", function (e) {
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
    if ($.fn.draggable) {
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
    }
});

/** Featured Instructor AJAX */
$(function () {
    $(document).on("change", ".select_instructor", function () {
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


