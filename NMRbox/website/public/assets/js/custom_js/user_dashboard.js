/**
 * Created by mosrur on 5/31/17.
 */

$(document).ready(function () {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function () {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function () {
            //Completed slidetoggle
            if (idFor.is(':visible')) {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });


    $('[data-toggle="tooltip"]').tooltip();
    $('[rel="tooltip"]').tooltip();

    $('button').click(function (e) {
        e.preventDefault();
    });

    /* show/hide password*/
    $('.showHide').on('click', function(e){
        var target_id = $(this).attr('data-target');
        if($("#"+target_id).attr("type") == 'password') {
            $('input#'+target_id).attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('input#'+target_id).attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    /* saving the data into LDAP */
    $("#save_ldap_pass").on("click", function (e) {
        e.preventDefault();
        /* Saving password delay moments*/
        $('#ldap_pass').after('<span id="ldap_pass_loading">Saving Password...</span>');

        var pass = $('#ldap_pass').val();
        var conf_pass = $('#conf_pass').val();

        if(pass != conf_pass){
            /* Checking password and confirm password */
            $('#ldap_pass_loading').remove();
            $('#error_msg').html('Password and Confirm password do not match. Please try again.');
            show_alert('error');
        } else {
            /* Changing form input type */
            $('input#ldap_pass').attr('type', 'hidden');
            $('input#save_ldap_pass').attr('type', 'hidden');


            $.ajax({
                type: "POST",
                url: 'change-password',
                data: 'pass=' + pass +'&_token=' + $('input#user_csrf_token').val(),
                dataType: 'JSON',
                success: function(data) {


                    if(data.type == 'success'){
                        /* Activating the fields*/
                        $('#ldap_pass_loading').remove();
                        $('#pass_asterisk').show();
                        $('#show_pass_box').hide();
                        $('#conf_pass_box').hide();
                        $('#edit_ldap_pass').show();
                        /* Success message */
                        $('#success_msg').html(data.message);
                        /* removing error alert message */
                        $("#error-alert").slideUp();
                        show_alert('success');
                    } else {
                        /* Activating the fields*/
                        $('#ldap_pass_loading').remove();
                        $('input#ldap_pass').attr('type', 'password');
                        $('#edit_ldap_pass').hide();
                        $('#pass_asterisk').hide();
                        $('#conf_pass_box').show();
                        $('#show_pass_box').show();
                        $('#edit_ldap_pass').hide();
                        $('input#reset_ldap_pass').attr('type', 'reset');
                        $('input#save_ldap_pass').attr('type', 'submit');

                        /* Error message */
                        $('#error_msg').html(data.message);
                        $('#error_msg').html("Password "+ pass+ " does not meet complexity rules, please try again. Password must be a minimum of 8 characters and include a character from 3 of the following 4 groups: upper case, lower case, numbers, and punctuation marks ('&' and '$' no allowed).");
                        show_alert('error', 'no');
                    }
                },
                error: function (data) {
                    /* Activating the fields*/
                    $('#ldap_pass_loading').remove();
                    $('input#ldap_pass').attr('type', 'password');
                    $('#edit_ldap_pass').hide();
                    $('#pass_asterisk').hide();
                    $('#conf_pass_box').show();
                    $('#show_pass_box').show();
                    $('#edit_ldap_pass').hide();
                    $('input#reset_ldap_pass').attr('type', 'reset');
                    $('input#save_ldap_pass').attr('type', 'submit');

                    /* Success message */
                    $('#error_msg').html(data.message);
                    $('#error_msg').html("Password "+ pass+ " does not meet complexity rules, please try again. Password must be a minimum of 8 characters and include a character from 3 of the following 4 groups: upper case, lower case, numbers, and punctuation marks ('&' and '$' no allowed).");
                    show_alert('error', 'no');
                }
            })
        }
    });


    /* Verify LDAP authentication */
    $("#verify_pass").on("click", function (e) {
        e.preventDefault();
        var pass = $('#auth_pass').val();

        if(pass.length > 0){
            $.ajax({
                type: "POST",
                url: 'verify-password',
                data: 'pass=' + pass +'&_token=' + $('input#user_csrf_token').val(),
                dataType: 'JSON',
                success: function(data) {
                    if(data.type == 'success'){
                        /* Activating password reset form */
                        $('#pass_confirm_modal').modal('hide');
                        $('input#ldap_pass').attr('type', 'password');
                        $('#pass_asterisk').hide();
                        $('#conf_pass_box').show();
                        $('#show_pass_box').show();
                        $('#edit_ldap_pass').hide();
                        $('input#reset_ldap_pass').attr('type', 'reset');
                        $('input#save_ldap_pass').attr('type', 'submit');

                        /* Success message */
                        $('#success_msg').html(data.message);
                        show_alert('success');
                    } else {
                        /* Error message */
                        $('#pass_confirm_modal').modal('hide');
                        $('#error_msg').html(data.message);
                        show_alert('error');
                    }
                },
                error: function (data) {
                    /* Error message */
                    $('#pass_confirm_modal').modal('hide');
                    $('#error_msg').html(data.message);
                    show_alert('error');
                }
            })
        } else {
            /* Error for not entering any password*/
            $('#pass_confirm_modal').modal('hide');
            $('#error_msg').html("Please enter a valid password and try again. ");
            show_alert('error');
        }

    });

    /* register for workshop */
    $('button.btn_register_workshop').on('click', function(e){
        e.preventDefault();

        /* workshop name*/
        var name = $(this).attr('data-workshop');

        /* ajax request for workshop register */
        $.ajax({
            type: "POST",
            url: 'register_person_workshop',
            data: 'name=' + name + '&_token=' + $('input#user_csrf_token').val(),
            dataType: 'json',
            /*success: function(response) {
                $('#success_msg').html(response.message);
                show_alert('success');
                window.scrollTo(0,0);
                location.reload();
            },
            error: function (response) {
                $('#error_msg').html(" You already have been registered for this workshop.");
                show_alert('error');
            }*/
            success: function(response) {
                $("#all_workshops").load(location.href + " #all_workshops");
                $('#success_msg').html(response.message);
                show_alert('success', 'no');
                window.scrollTo(0,0);
            },
            error: function (response) {
                $('#error_msg').html(" You already have been registered for this workshop.");
                show_alert('error', 'no');
            }
        })

    })
});
