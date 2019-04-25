$(document).ready(function() {



    $('.delete-vm').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var num_attached_software = button.attr("data-software-count");
        var vm_name = button.attr("data-vmname");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete VM Version <br><span  class="modal-highlight">' + vm_name + '</span><br> with <br><span class="modal-highlight">' + num_attached_software + '</span> software packages attached? Attached software will not be deleted. <br> This action is not reversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});