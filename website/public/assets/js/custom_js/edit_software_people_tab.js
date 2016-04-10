$(document).ready(function() {

    $('.add-person-new').on('click', function (event) {
        add_new_person_form(event, $('#people-tab .add-person-new-form'), "");
    });

    $('.add-person-existing').on('click', function (event) {
        add_new_existing_person_form(event, $('#people-tab .add-person-existing-form'), "");
    });

    $('.add-person-cancel').on('click', function (event) {
        cancel_add_person(event, $('#people-tab .add-person-new-form'));
    });


    function add_new_person_form(event, target, text) {
        // target.show();
        // $('#people-tab .person-add-buttons').hide();
        // $('#people-tab #add-nag').hide();
    }

    function add_new_existing_person_form(event, target, text) {
        target.show();
        $('#people-tab .person-add-buttons').hide();
        $('#people-tab #add-nag').hide();
    }

    function cancel_add_person(event, target) {
        var button = $(event.target);
        $('#people-tab .add-person-existing-form').hide();
        $('#people-tab .add-person-new-form').hide();
        $('#people-tab .person-add-buttons').show();
    }

    // functionality when clicking on a delete-pair button
    $('#people-tab .detach-person').on('click', function(event) {
        var button = $(event.target);
        var name = button.attr("data-name");
        var url = button.attr("data-url")

        var m = $('#admin-modal');
        m.find('.modal-title').text('Detach Confirmation');
        m.find('.modal-body').html('Are you sure you want to detach this person? <br><span  class="modal-highlight">' + name + '</span>');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

});