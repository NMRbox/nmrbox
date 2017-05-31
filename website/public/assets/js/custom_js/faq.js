$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // DataTable
    var table = $('#vm-table').DataTable( {
        "order": [[ 1, "asc" ]],
    });

    // deleting confirmation
    $('.delete_faq').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var template_name = button.attr("data-name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this FAQ? <br><span  class="modal-highlight">' + name + '</span><span class="modal-highlight"></span>');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

});
