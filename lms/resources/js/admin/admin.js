import $ from 'jquery';
import { Notyf } from 'notyf';

window.$ = window.jQuery = $;

/** Notyf init */
const notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'top' },
    dismissible: true
});

const csrf_token = $(`meta[name="csrf_token"]`).attr('content');
const base_url = $(`meta[name="base_url"]`).attr('content');

var delete_url = null;

// Initialize admin functionality
$(document).ready(function() {
    console.log('Admin JS loaded');
    initDeleteHandlers();
});

function initDeleteHandlers() {
    /** Delete Item with confirmation */
    $('.delete-item').on('click', function(e) {
        e.preventDefault();
        delete_url = $(this).data('delete-url');
        const modal = new bootstrap.Modal(document.getElementById('modal-danger'));
        modal.show();
    });

    $('.delete-confirm').on('click', function(e) {
        e.preventDefault();
        const $confirmBtn = $(this);
        
        $.ajax({
            method: 'DELETE',
            url: delete_url,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            beforeSend: function() {
                $confirmBtn.prop('disabled', true).text("Deleting...");
            },
            success: function(response) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modal-danger'));
                modal.hide();
                notyf.success('Deleted successfully');
                // Remove the deleted row from the table
                $(`[data-delete-url="${delete_url}"]`).closest('tr').fadeOut(400, function() {
                    $(this).remove();
                    // If no rows left, show "No Data Found" message
                    if ($('tbody tr').length === 0) {
                        $('tbody').html('<tr><td colspan="3" class="text-center">No Data Found!</td></tr>');
                    }
                });
            },
            error: function(xhr, status, error) {
                let errorMessage = xhr.responseJSON?.message || 'Something went wrong';
                notyf.error(errorMessage);
                const modal = bootstrap.Modal.getInstance(document.getElementById('modal-danger'));
                modal.hide();
            },
            complete: function() {
                $confirmBtn.prop('disabled', false).text("Delete");
            }
        });
    });
}
