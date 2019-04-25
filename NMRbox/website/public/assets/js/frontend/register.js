$(document).ready(function(){
    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%' // optional
    });

    /* Select User Last name as PI if Job Title select as PI */
    $('body').on('change', 'select.select_pi', function (e) {
        e.preventDefault();
        var val = $(this).val();
        console.log(val);
        if(val == 'PI'){
            var last_name = $("input[name='last_name']").val();
            $("input[name='pi']").val(last_name);
        } else {
            $("input[name='pi']").val('');
        }
    });
});