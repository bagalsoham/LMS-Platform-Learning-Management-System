const csrf_token = $('meta[name="csrf-token"]').attr("content");
/* console.log(csrf_token); // Should now log the token
 */


var notyf = new Notyf({
    duration: 5000,
    dismissible: true,
});

/*  Ez share  */

document.addEventListener("DOMContentLoaded", function () {
    ezShare.execute();
});

$(function () {
    //dynamic delete popup
    $(".delete-item").on("click", function (e) {
        e.preventDefault();
        console.log(csrf_token);
        let url = $(this).attr("href");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
                    url: url,
                    data: {
                        _token: csrf_token,
                    },
                    success: function (data) {
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        notyf.error(error);
                    },
                });
            }
        });
    });
});
