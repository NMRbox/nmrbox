/**
 * Created by mosrur on 5/31/17.
 */
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // DataTable
    var table = $('#vm-table').DataTable( {
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
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
            success: function(response) {
                $('#success_msg').html(response.message);
                show_alert('success');
                window.scrollTo(0,0);
                location.reload();
            },
            error: function (response) {
                $('#error_msg').html(" You already have been registered for this workshop.");
                show_alert('error');
            }
        })
    });

    // deleting confirmation
    $('.delete_workshop').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var template_name = button.attr("data-name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this workshop? <br><span  class="modal-highlight">' + name + '</span><span class="modal-highlight"></span>');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});
