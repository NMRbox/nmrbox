$(document).ready(function() {



    $('.delete-person').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var person_name = button.attr("data-lab_role");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this person? <br><span  class="modal-highlight">' + person_name + '</span><span class="modal-highlight"></span> <br> This action is not reversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});