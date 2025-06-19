const base_url = $('meta[name="base_url"]').attr('content'); // Fixed: Added missing quote
const basic_info_url = base_url + '/instructor/courses/create';

$('.basic_info_form').on('submit', function(e) {
    e.preventDefault();

    let formData = $(this).serialize();
    console.log(formData);
    console.log('Sending request to:', basic_info_url); // Debug: Log the actual URL

    $.ajax({
        method: "POST",
        url: basic_info_url, // Fixed: Removed quotes to use variable
        data: formData,
        beforeSend: function() {
            // Loading state - you can add loading spinner here
            console.log('Sending request...');
        },
        success: function(data) {
            // Handle success
            console.log('Success:', data);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log('Error:', xhr.status, xhr.responseText);
        },
        complete: function() {
            // Always runs
            console.log('Request completed');
        }
    });
});
