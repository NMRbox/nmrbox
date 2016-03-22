$(document).ready(function() {

    window.NMR= {
        "edit_software_index": 1 // global var to increment new label names, eg "new label 1", "new label 2"
    };

    $('.textarea').summernote(); // turns .textareas into rich text editing boxes using summernote

    $('.nmr-file-upload label').on("keyup", labelNameMatch);  // this provides auto-capitalization for the name field


    // these functions handle the creation of additional fields or forms for data entry on their respective tabs
    $('.add-file').on('click', function(event) {
        add_new_file_form(event, $('#files-tab form'), "");
    });
    $('.add-image').on('click', function(event) {
        add_new_file_form(event, $('#images-tab form'), "image");
    });
    $('.add-license').on('click', function(event) {
        add_new_file_form( event, $('#files-tab form'), "Original License");
    });
    $('.add-version').on('click', function(event) {
        add_new_version_form( event, $('#versions-tab .version-form'), "");
    });
    $('.add-version-pair').on('click', function(event) {
        add_new_version_pair_form( event, $('#versions-tab'));
        $(event.target).hide();
    });


    function labelNameMatch(event) {
        var label = $(event.target);
        var input_el = label.siblings("div").find("input");
        input_el.attr("name", label.html());
    }

    function add_new_version_pair_form(event, target) {
        var template = $('#software-pair-template');
        // copy template rendered using blade because we need the VM and Software ids in the html selects
        var new_form = template.clone().attr("id", "");
        template.before(new_form);
        $(".btn.versions-pair-cancel", new_form).on("click", cancel_versions_pair);
    }


    function add_new_version_form(event, target, text) {
        var files_form = target;

        if(text == "image") {
            text = text + "-" + NMR.edit_software_index++;
        }
        else if(text) {
            // pass parameter to html
        }
        else {
            text = "Software Version " + NMR.edit_software_index++;
        }

        var new_version_html =
            '<div class="form-group nmr-new-version">' +
            '<div>' +
            '<input class="form-control form-control" placeholder="eg. 4.0.1" data-buttonbefore="true" id="input-id" name="version[]" type="text">' +
            '</div>' +
            '<button type="button" class="btn btn-danger delete-version">Cancel</button>' +
            '</div>';

        // add the new html after the current last file upload form-group
        $(".form-group:nth-last-child(2)", files_form).before(new_version_html);

        // add label name matcher function to newly created form-goup, which is now the last file upload in the form
        var new_el = $(".form-group:nth-last-child(3)", files_form);

        // add the cancel button functionality
        $(".btn.delete-version", new_el).on("click", cancel_version);

        // show the save button
        $(".save-new-software-version").show();
    }

    function add_new_file_form(event, target, text) {
        var files_form = target;

        if(text == "image") {
            text = text + "-" + NMR.edit_software_index++;
        }
        else if(text) {
            // pass parameter to html
        }
        else {
            text = "File label " + NMR.edit_software_index++;
        }

        if( target.find("input[name='" + text + "']").length > 0 ) {
            // then there is already an input by the same name in the form
            text = text + " " + NMR.edit_software_index++; // break the dupe by adding an (or another) index number
        }

        var new_file_html =
            '<div class="form-group nmr-file-upload">' +
            '<label class="control-label form-control input-lg" for="short_title" contentEditable="true">' + text + '</label>' +
            '<div>' +
            '<input class="form-control form-control" data-buttonbefore="true" id="input-id" name="' + text + '" type="file">' +
            '</div>' +
            '<button type="button" class="btn btn-danger delete-file">Cancel</button>' +
            '</div>';

        // add the new html after the current last file upload form-group
        $(".form-group:nth-last-child(2)", files_form).before(new_file_html);

        // add label name matcher function to newly created form-goup, which is now the last file upload in the form
        var new_el = $(".form-group:nth-last-child(3)", files_form);
        new_el.on("keyup", labelNameMatch);

        // add the cancel button functionality
        $(".btn.delete-file", new_el).on("click", cancel_file_upload);
    }

    // these handle cancel buttons on various tabs
    function cancel_file_upload(event) {
        var button = $(event.target);
        button.parents(".form-group").remove();
    }

    function cancel_version(event) {
        var button = $(event.target);
        //debugger;

        var form = button.parents(".version-form");

        if( $(form).children(".nmr-new-version").length > 1 ) {
            //then there are still other active fields, excluding the one we are about to delete, that may be submitted
        }
        else {
            // no more active fields, so hide the submit button
            $(".save-new-software-version").hide();
        }


        button.parents(".form-group").remove();

    }

    function cancel_versions_pair(event) {
        var button = $(event.target);
        button.parents(".software-pair-container").remove();
        $('.add-version-pair').show();
    }

    // this triggers a modal when the user clicks on the delete button
    $('.delete-file').on("click", function(event) {
        event.preventDefault();
        var button = $(event.target);
        var label = button.attr("data-label");
        var filename = button.attr("data-filename");
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete <br><span  class="modal-highlight">' + filename + '</span><br> labeled as <br><span class="modal-highlight">' + label + '</span>?');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

    // functionality when clicking on an edit-version button
    $('.edit-version').on('click', function(event) {
        var button = $(event.target);
        var input = button.parent().siblings(".version-display-edit-box")

        button.hide();
        button.siblings(".delete-version").hide();
        button.siblings(".save-edit-version").show();
        button.siblings(".cancel-edit-version").show();

        input.attr("class", "version-display-edit-box form-control"); // make input look like an input
        input.attr("contenteditable", "true"); // make input content editable

        button.siblings(".save-edit-version").on("click", function(event) {
            var button = $(event.target);
            var input = button.parent().siblings(".version-display-edit-box")
            var edit_url = input.attr("data-url") + "/" + input.text(); // contents of input area
            window.location.href = edit_url; // send GET to software.versionsedit route
        });

        button.siblings(".cancel-edit-version").on("click", function(event) {
            var button = $(event.target);

            input.attr("class", "version-display-edit-box"); // remove form-control
            input.attr("contenteditable", ""); // make input content editable

            button.siblings(".edit-version").show();
            button.siblings(".delete-version").show();
            button.siblings(".save-edit-version").hide();
            button.hide();
        });
    });

    // functionality when clicking on a delete-version button
    $('.delete-version').on('click', function(event) {
        var button = $(event.target);
        var input = button.parent().siblings(".version-display-edit-box");
        var version = input.text();
        var url = input.attr("data-url") + "/delete";

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete software version <br><span  class="modal-highlight">' + version + '</span>? <br> This action is irreversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });

    // functionality when clicking on a delete-pair button
    $('.delete-pair').on('click', function(event) {
        var button = $(event.target);
        var pair_text = button.siblings(".pair-text").text();
        var url = button.attr("data-url");

        var m = $('#admin-modal');
        m.find('.modal-title').text('Delete Confirmation');
        m.find('.modal-body').html('Are you sure you want to delete this pair? <br><span  class="modal-highlight">' + pair_text + '</span> <br> This action is irreversible!');

        var mbutton = m.find('.modal-action');
        mbutton.attr("onclick", "window.location.href='" + url + "'");
        mbutton.removeClass();
        mbutton.addClass("btn btn-danger");
        mbutton.text("Delete");
        m.modal();
    });
});