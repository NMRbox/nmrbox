$(document).ready(function() {
    $('.delete-category').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var category_name = button.attr("data-category_name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this category? <br><span  class="modal-highlight">' + category_name + '</span><span class="modal-highlight"></span> ');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});