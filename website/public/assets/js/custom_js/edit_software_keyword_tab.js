$(document).ready(function() {

    $('.add-keyword-new').on('click', function (event) {
        add_new_keyword_form(event, $('#keywords-tab .add-keyword-new-form'), "");
    });

    $('.add-keyword-existing').on('click', function (event) {
        add_new_existing_keyword_form(event, $('#keywords-tab .add-keyword-existing-form'), "");
    });

    $('.add-keyword-cancel').on('click', function (event) {
        cancel_add_keyword(event, $('#keywords-tab .add-keyword-new-form'));
    });


    function add_new_keyword_form(event, target, text) {
        // target.show();
        // $('#keywords-tab .keyword-add-buttons').hide();
        // $('#keywords-tab #add-nag').hide();
    }

    function add_new_existing_keyword_form(event, target, text) {
        target.show();
        $('#keywords-tab .keyword-add-buttons').hide();
        $('#keywords-tab #add-nag').hide();
    }

    function cancel_add_keyword(event, target) {
        var button = $(event.target);
        $('#keywords-tab .add-keyword-existing-form').hide();
        $('#keywords-tab .add-keyword-new-form').hide();
        $('#keywords-tab .keyword-add-buttons').show();
    }

    // functionality when clicking on a delete-pair button
    $('#keywords-tab .detach-keyword').on('click', function(event) {
        var button = $(event.target);
        var name = button.attr("data-name");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Detach Confirmation');
        m.find('.modal-body').html('Are you sure you want to detach this keyword? <br><span  class="modal-highlight">' + name + '</span>');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

});