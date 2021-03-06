$(document).ready(function() {
    /* page alert message box */
    $("#success-alert").hide().removeClass('hidden');
    $("#error-alert").hide().removeClass('hidden');

    // classification checkbox elements
    $('label', $('.fancy-checkbox-holder')).children('input[type="checkbox"]').hide();
    $('label', $('.fancy-checkbox-holder')).prepend('<i class="fa fa-fw"></i>');
    $('label', $('.fancy-checkbox-holder')).on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass('partial-checked').removeClass('unchecked').toggleClass('checked');
        if($(this).hasClass('checked')) {
            $(this).children('input[type="checkbox"]').attr('checked', 'checked');
        } else {
            $(this).children('input[type="checkbox"]').removeAttr('checked');
        }
    });

    //$('#vm-table').DataTable();
    var selected = [];

    // Setup - add a text input to each footer cell
    $('#vm-table thead th.ref_search').each( function (index) {
        if(!$(this).hasClass('no-search')) {
            var title = $(this).text();
            if (title.length > 0) {
                $(this).html('<input type="text" size="10" placeholder=" ' + title + '" class="advanced-search" id="advanced_search_' + index + '" />');
            }
        }
    } );

    // DataTable declaration
    var table = $('#vm-table').DataTable( {
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ]
    });

    /* search empty field in table */
    $('#search_empty_val').on('click', function(e){
        e.preventDefault();
        table.column(4).search("^$", 1, 0).draw();
    });

    /* Advance search option based on particular db fields */
    $('input.advanced-search').on('keyup change', function(){
        var col_index = $(this).attr('id').substr('advanced_search_'.length);
        table.column(col_index).search($(this).val()).draw();
    });

    /* Selecting/Deselecting particular single rows */
    $('#vm-table tbody').on('click', 'tr', function() {
        var id = this.id;
        var index = $.inArray(id, selected);
        if(index === -1) {
            selected.push(id);
        } else {
            selected.splice(index, 1);
        }
        $(this).toggleClass('selected');

    });


    /* Select all the refined field*/
    $('a#btn_select_all').on('click', function(e) {
        e.preventDefault();
        selected = [];

        var rows = table.$('tr', {"filter":"applied"}).addClass('selected');
        if(rows.length == 0) {
            table.$('tr').addClass('selected');
        }

        rows.each(function(){
            var r_selected = table.row(this);
            selected.push($(this).attr('id'));
        });
    });

    /* Deselect all the refined field*/
    $('a#btn_deselect_all').on('click', function(e) {
        e.preventDefault();
        selected = [];
        table.$('tr').removeClass('selected');
    });

    /* show/hide mail recipient box */
    $('body').on('click', '#show_mail_recipients_box', function(e){
        e.preventDefault();
        $('#mail_recipients_list').toggleClass('hidden');
    });


    // load user details for sending email
    $('#email_utility').on('click', function(e){
        e.preventDefault();

        if(selected.length > 0) {
            $.ajax({
                type: "POST",
                url: 'people/get_user_details',
                data: 'ids=' + JSON.stringify(selected) + '&_token=' + $('input#user_csrf_token').val(),
                success: function (data) {
                    var users_count = selected.length;
                    var users = data.users;

                    if(users_count == users.length){
                        var user_data = "<div><a href='javascript:' id='show_mail_recipients_box'> " + users_count + " persons </a></div>";
                        user_data += "<div class='hidden' id='mail_recipients_list'>";
                        user_data += "<table class='table'><thead><tr><th>ID</th><th>Full Name</th><th>Email</th></tr></thead><tbody>";
                        $.each(users, function (index, value) {

                            user_data += "<tr>"
                                + "<td>" + value.id + "</td>"
                                + "<td>" + value.first_name + '&nbsp;' +value.last_name + "</td>"
                                + "<td class='user_email'><div class='preferred_email'> " + value.email + "</div><div class='institutional_email hidden'> " + value.email_institution + "</div></td>"
                                + "</tr>";
                        });
                        user_data += "</tbody></table></div>";
                    }

                    /* appending the user_data into email model */
                    $('#user_details').empty().append(user_data);

                },
                error: function (data) {
                    $('#error_msg').html('Something went wrong. Please try again.');
                    show_alert('error');
                }
            })
        } else {
            /* If no row selected */
            $('#email_modal').modal('toggle');
            $('#error_msg').html('No rows selected. Please try again.');
            show_alert('error');
        }
    });

    /* Change recipient email address based on the selection */
    $(document).on("change", "#recipient_address", function(e){
       e.preventDefault();
       /* selection value */
       var email_address = $(this).val();

       if(email_address == 'email'){
           $('.preferred_email').removeClass('hidden');
           $('.institutional_email').addClass('hidden');
       } else {
           $('.preferred_email').addClass('hidden');
           $('.institutional_email').removeClass('hidden');
       }
    });

    /* populating Email template */
    $(document).on("change", '#email_template', function(e) {
        e.preventDefault();
        var template_id = $(this).val();

        $.ajax({
            type: "POST",
            url: 'people/email_template',
            data: 'id=' + template_id + '&_token=' + $('input#user_csrf_token').val(),
            success: function(data) {
                $('input#email_subject').val(data.subject);
                $('textarea#message').val(data.message);
            }
        });

    });

    /* Email all the selected person*/
    $('button#send_email').on('click', function(e) {
        e.preventDefault();
        if(selected.length > 0) {
            var form_data = $("#email_template_form").serialize();

            $.ajax({
                type: "POST",
                url: 'people/send_email',
                data: 'ids=' + JSON.stringify(selected) + '&' + form_data + '&_token=' + $('input#user_csrf_token').val(),
                success: function (data) {
                    $('input, textarea', $('#email_template_form')).val('');
                    $('#email_modal').modal('hide');
                    $('#success_msg').html(data.message);
                    show_alert('success');
                    location.href = '/admin/people';
                },
                error: function (data) {
                    $('#email_modal').modal('hide');
                    $('#error_msg').html('Something went wrong. Please try again.');
                    show_alert('error');
                }
            })
        } else {
            /* If no row selected */
            $('#email_modal').modal('hide');
            $('#error_msg').html('Something went wrong. Please try again.');
            show_alert('error');
        }

    });

    /* Display email template name input field */
    $("input[name$='save_template']").click(function(e) {
        var val = $(this).val();

        if(val == 'yes') {
            $('#template_name_box').toggle();
        } else {
            $('#template_name_box').hide();
        }
    });

    /* Display title input box for classification tags */
    $("input[name$='save_classification']").click(function(e) {
        var val = $(this).val();

        if(val == 'yes') {
            $('#name_box').toggle();
        } else {
            $('#name_box').hide();
        }
    });

    // load user assigned classification information
    $('#user_classification').on('click', function(e){
        e.preventDefault();

        if(selected.length > 0) {
            $.ajax({
                type: "POST",
                url: 'people/get_users_classification',
                data: 'ids=' + JSON.stringify(selected) + '&_token=' + $('input#user_csrf_token').val(),
                success: function (data) {
                    var list = data.message;

                    var users_count = selected.length;
                    $.each(data.message, function (index, value) {
                        var class_id = index.toLowerCase().replace(' ', '_');

                        var array_count = value.length;
                        if(users_count == array_count){
                            $("#group_check_"+class_id).addClass('checked');
                            $("#group_check_"+class_id).children('input[type="checkbox"]').attr('checked', 'checked');
                        } else if(array_count > 0 && array_count < users_count){
                            $("#group_check_"+class_id).addClass('partial-checked');
                        } else {
                            $("#group_check_"+class_id).addClass('unchecked');
                        }

                    });

                },
                error: function (data) {
                    $('#error_msg').html('Something went wrong. Please try again.');
                    show_alert('error');
                }
            })
        } else {
            /* If no row selected */
            $('#user_classification_modal').modal('toggle');
            $('#error_msg').html('No rows selected. Please try again.');
            show_alert('error');
        }
    });


    /* Assign tags to all the selected person*/
    $('button#assign_classification').on('click', function(e) {
        e.preventDefault();
        var form_data = $("#assign_classification_form").serialize();

        // assign partial fields
        var partial_checked = [];
        $('label.partial-checked input[type="checkbox"]').each(function(){
            partial_checked.push($(this).attr('value'));
        });

        $.ajax({
            type: "POST",
            url: 'people/assign_classification',
            data: 'ids=' + JSON.stringify(selected) + '&partial_checked=' + JSON.stringify(partial_checked) + '&' + form_data + '&_token=' + $('input#user_csrf_token').val(),
            success: function (data) {
                $('input, textarea', $('#assign_classification_form')).val('');
                $('#user_classification_modal').modal('toggle');
                $('#success_msg').html(data.message);
                show_alert('success');
                location.href = '/admin/people';
            },
            error: function (data) {
                $('#user_classification_modal').modal('toggle');
                $('#error_msg').html('Selection of either user, developer or admin is mandatory.');
                show_alert('error');
                location.href = '/admin/people';
            }
        })

    });

    /* Delete a person entry */
    $('.delete-person').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var person_name = button.attr("data-person_name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this person? <br><span  class="modal-highlight">' + person_name + '</span><span class="modal-highlight"></span> <br><br> This action will also delete any associated website-level account (not CAM accounts) <br> <br> This action is not reversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

    /* Show/Hide Advance search box */
    $("#adv_search_box_button").on('click', function(e){
        e.preventDefault();
        $("div#adv_search_box").toggleClass('hidden');
    });

    /* Advance search */
    $('button#adv_search_button').on('click', function (e) {
        e.preventDefault();
        var request_input = $("#search_input").val().replace(/,(\s*)/g, "|");
        table.column(0).search("^("+request_input+")$", 1, 0).draw();
    });

    /* Advance search reset / clear filter*/
    $('button#adv_search_reset').on('click', function (e) {
        e.preventDefault();
        // resetting select all/ deselect all
        selected = [];
        table.$('tr').removeClass('selected');
        // resetting search-by-id form input field
        $('.form-inline').find("input[type=text], textarea").val("");
        // resetting datatables column based filter search input
        $('#vm-table thead input').val('').change();
        // resetting datatable filter result
        table
            .search( '' )
            .columns().search( '' )
            .draw();
        //clearing the filter search
        table.fnFilterClear();
    });

});



/* Alert box */
function show_alert(alert_type) {

    $("#"+alert_type+"-alert").alert();
    $("#"+alert_type+"-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#"+alert_type+"-alert").slideUp(500);
    });
}

/* signle row view */
$(document).on("click", "#show_user", function () {
    var id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: 'people/show',
        data: 'id=' + id +'&_token=' + $('input#user_csrf_token').val(),
        dataType: 'JSON',
        success: function(response) {
            $("#modal-header-title").text( response.user['first_name'] + ' ' + response.user['last_name'] );

            //Show content within modal body
            $("#user_details_modal .modal-body").html(
                'First Name:&nbsp;' + response.user['first_name'] + '<br>' +
                'last Name:&nbsp;' + response.user['last_name'] + '<br>' +
                'Email:&nbsp;' + response.user['email'] + '<br>'
            )
        },
        error: function (data) {
            $('#error_msg').html('No rows selected. Please try again.');
            show_alert('error');
        }
    })

});

jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                //For browsers like Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                //For browsers like Firefox and Webkit based
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        });
    }
});

$('#template_area a').click(function(){
    var val = $(this).attr('data-field-name');
    $('textarea').insertAtCaret( "%%" + val + "%%");
})



