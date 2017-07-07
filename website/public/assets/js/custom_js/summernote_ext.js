/**
 * Created by mosrur on 7/7/17.
 */

$(document).ready(function() {
    /* customized FileButton */
    var FileButton = function(context) {
        var ui = $.summernote.ui;

        // create button
        var button = ui.button({
            contents: '<i data-toggle="modal" data-target="#resource_modal" class="fa fa-file-o"/> ',
            tooltip: 'Insert File',
            click: function () {
                // invoke insertText method with 'hello' on editor module.
                // context.invoke('editor.insertText', 'hello');
                //context.invoke(uploadImage, 'hello');
            }
        });

        return button.render();   // return button as jquery object
    };

    /* defining the editor buttons & tabs*/
    $('.textarea').summernote({
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table', 'hr']],
            ['insert', ['link', 'picture', 'files']],
            ['view', ['fullscreen', 'codeview']],
            ['mybutton', []]
        ],
        buttons: {
            files: FileButton
        },
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
        }
    });

    /* File insertion process */
    $('button#insert_files').on('click', function(e){
        e.preventDefault();
        $('input.modal_files:checked').each(function () {

            /* file slug & name */
            var file_name = $(this).data('name');
            var file_slug = $(this).val();

            /* appending the value to textarea */
            $('.note-editable.panel-body').append("<p style='font-size: 19px; line-height: 29px;' target='_blank'><a href='"+file_slug+"'>" + file_name +"</a></p>");
            $('textarea.textarea').val($('.note-editable.panel-body').html());

        })

        /* closing modal */
        $('#resource_modal').modal('toggle');
    });
});
