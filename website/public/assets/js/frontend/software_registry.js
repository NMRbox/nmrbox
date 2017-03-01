/**
 * Created by mosrur on 1/30/17.
 */

/* Alert box */
function show_alert(alert_type) {

    $("#"+alert_type+"-alert").alert();
    $("#"+alert_type+"-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#"+alert_type+"-alert").slideUp(500);
    });
}

/* page alert message box */
$("#success-alert").hide().removeClass('hidden');
$("#error-alert").hide().removeClass('hidden');

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* hide the advance search form */
    $('#search_form').hide();
    $('a.clear_filter_box').hide();

    /* Select all the refined field*/
    $('a#software_registry_search').on('click', function (e) {
        e.preventDefault();
        if ($('#search_form').is(':hidden')) {
            $('#search_form').slideDown();
            $('a.clear_filter_box').show();
            $('.select_field').removeAttr('selected').find('option:first').attr('selected', 'selected');
        } else {
            $('#search_form').slideUp();
            $('a.clear_filter_box').hide();
        }

    });

    /* preventing form submit */
    $('body').on('submit', function (e) {
        e.preventDefault();
        return false;
    })

    var row_html = '<div class="form_row">' + $('.form_row').html() + '</div>';
    $('body').on('change', 'select.select_field', function (e) {
        e.preventDefault();
        var value = $(this).val();
        var form_input_field = '';
        var field = this;

        if(value == 'software_category'){

            $.ajax({
                type: "GET",
                url: 'tags/all-tags',
                success: function (data) {
                    form_input_field += "<select name='menus[]' class='form-control tags_dropdown search_fields'>";
                    form_input_field += "<option value=''>-- Please select -- </option>";
                    $.each(data.message, function(key, value) {
                        form_input_field += "<option value='"+value.id+"'>"+value.label+"</option>";
                    })
                    form_input_field += "</select>";
                    $($(field).parent()[0]).siblings('.form_input_field').html(form_input_field);

                },
                error: function (data) {
                    $('#error_msg').html('Something went wrong. Please try again.');
                    show_alert('error');
                }
            });

        } else if(value == 'vm_version') {
            form_input_field = "<select name='vm_version[]' class='form-control search_fields'>" +
                "<option value=''> -- Please select -- </option>" +
                "<option value='1'>NMRbox Ver 1</option>" +
                "<option value='2'>NMRbox Ver 2</option>" +
                "</select>";
        } else if(value == 'author_name') {
            form_input_field = "<input type='text' name='author_name[]' placeholder='John Doe' class='form-control search_fields'>";
        }else {
            form_input_field = "<input type='text' name='fields_value["+value+"]' placeholder='nmrbox' class='form-control search_fields'>";
        }
        // remove button
        var form_button = "<a href='#' class='btn btn-sm btn-warning remove_button'><span class='glyphicon glyphicon-minus'></span></a>";

        // Adding the second column input boxes
        $($(this).parent()[0]).siblings('.form_input_field').html(form_input_field);
        $('a.add_now_button').show();

        // Adding the remove button for each row
        if($('.form_row').length > 1) {
            if($($(this).parent()[0]).siblings('.form_button').children('.remove_button').length == 0)
            {
                $($(this).parent()[0]).siblings('.form_button').prepend(form_button);
            }
        }
    });
    var add_button = '<a href="#" class="btn btn-sm btn-info add_now_button"><span class="glyphicon glyphicon-plus"></span></a>';

    /* Remove a row from the selection */
    $('body').on('click', 'a.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().remove();
        $('.add_now_button').remove();
        $('.form_row').last().find('.form_button').append(add_button);
    });

    /* Add one more row */
    $('body').on('click', 'a.add_now_button', function (e) {
        e.preventDefault();
        $('.add_now_button').remove();
        $('#search_button').before(row_html);

    });

    /* clear filters to refresh the page */
    $('body').on('click', 'a#clear_filters', function (e) {
        e.preventDefault();
        location.href = '/registry';
    });

    /* populating the search result */
    $('body').on('keyup change', '.search_fields', function (e) {
        e.preventDefault();
        var form_data = $('#soft_reg_search').serialize();

        $.ajax({
            type: "POST",
            url: 'registry/software-search',
            data: form_data,
            dataType: 'json',
            success: function (data) {
                console.log(data.message);
                var soft_array = data.message;

                $('#filter_result').html("");

                $.each(soft_array, function( key, value ) {
                    $('#filter_result').append('' +
                        '<div class="col-sm-3 registry-package">' +
                            '<div class="registry-package-wrapper">' +
                                '<h3>' +
                                    '<a href="registry/'+value.slug+'">' +
                                        value.name +
                                    '</a>' +
                                '</h3>' +
                                '<p class="description">' +
                                    value.synopsis +
                                '</p>' +
                            '</div>' +
                        '</div>'
                    );
                });
            },
            error: function (data) {
                $('#filter_result').append('' +
                    '<div class="col-sm-3 registry-package">' +
                    '<div class="registry-package-wrapper">' +
                    '<h3>' +
                    'No software found.' +
                    '</h3>' +
                    '</div>' +
                    '</div>'
                );
            }
        });


    })
});
