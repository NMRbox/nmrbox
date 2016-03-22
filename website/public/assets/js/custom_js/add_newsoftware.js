$(document).ready(function() {
    $('.textarea').summernote();
    $('.select2').select2({
        //placeholder: placeholder // there is no placeholder variable defined
    });
});

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].square-blue').iCheck({
    checkboxClass: 'icheckbox_square-blue'
});