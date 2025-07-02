console.log('Cart.js loaded');
/** variables */
const base_url = $(`meta[name="base_url"]`).attr('content');
const csrf_token= $(`meta[name="csrf-token"]`).attr('content');

/** reusable functions */
function addToCart(courseId, $btn) {
    $.ajax({
        method: "POST",
        url: base_url + "/add-to-cart/" + courseId,
        data: {
            _token: csrf_token
        },
        beforeSend: function() {
            $btn.text('Adding...');
        },
        success: function(data) {
            $('.cart_count').html(data.cart_count);
            notyf.success(data.message);
            $btn.text('Add To Cart');
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            let errorMessage = xhr.responseJSON.message;
            notyf.error(errorMessage);
            $btn.text('Add To Cart');
        }
    });
}

/** On Dom Load */
$(function() {
   /** add course into cart - delegated event binding for dynamic content */
   $(document).on('click', '.add_to_cart', function (e) {
       e.preventDefault();
       let courseId = $(this).data('course-id');
       addToCart(courseId, $(this));
   });
});

export { addToCart };
