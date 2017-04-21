$(document).ready(function() {
    /*csrf token */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
    $('.select2').select2({
        //placeholder: placeholder
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

    /* File upload process */
    function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        $.ajax({
            url: '/files/save',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {

                if(url.indexOf('png') >= 0 || url.indexOf('jpg') >= 0 || url.indexOf('jpeg') >= 0) {
                    // then for now let's call this an image
                    var image = $('<img>').attr('src', url);
                    $('.textarea').summernote("insertNode", image[0]);

                }
                else {
                    // TODO: add a download attribute to this so you don't get slugified filenames on download
                    // https://davidwalsh.name/download-attribute
                    $('.textarea').summernote('createLink', {
                        text: url,
                        url: url,
                        newWindow: true
                    });
                }



            },
            error: function(data) {
                console.log(data);
            }
        });
    }


});

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].square-blue').iCheck({
    checkboxClass: 'icheckbox_square-blue'
});
