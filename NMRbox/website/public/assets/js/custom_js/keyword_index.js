$(document).ready(function() {
    $('.delete-keyword').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var keyword_label = button.attr("data-keyword_label");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this keyword? <br><span  class="modal-highlight">' + keyword_label + '</span><span class="modal-highlight"></span> ');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});