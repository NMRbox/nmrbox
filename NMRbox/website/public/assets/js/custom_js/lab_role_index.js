$(document).ready(function() {



    $('.delete-lab_role').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var name = button.attr("data-name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this role? <br><span  class="modal-highlight">' + name + '</span><span class="modal-highlight"></span> <br> This action is not reversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});