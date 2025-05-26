import $ from 'jquery';

$('.toggle-password').on('click', function(e){
    e.preventDefault();
    let field = $(this).closest('.input-group').find('.password');
    if(field.attr('type') === 'password'){
        field.attr('type', 'text');
    } else {
        field.attr('type', 'password');
    }
});