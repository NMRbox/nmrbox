$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var HelloButton = function(context) {
        var ui = $.summernote.ui;

        // create button
        var button = ui.button({
            contents: '<i class="fa fa-child"/> Hello',
            tooltip: 'hello',
            click: function () {
                // invoke insertText method with 'hello' on editor module.
                // context.invoke('editor.insertText', 'hello');
                context.invoke(uploadImage, 'hello');
            }
        });

        return button.render();   // return button as jquery object
    };

    $('.textarea').summernote({
    	height: 500, 
    	toolbar: [
		    ['style', ['style']],
		    ['font', ['bold', 'italic', 'underline', 'clear']],
		    ['color', ['color']],
		    ['para', ['ul', 'ol', 'paragraph']],
		    // ['height', ['height']],
		    ['table', ['table']],
		    ['insert', ['link', 'picture', 'hr']],
		    ['view', ['fullscreen', 'codeview']],
			['mybutton', ['hello']]
		  ],
        // buttons: {
        //     hello: HelloButton
        // },
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
        }
    });
    $('.select2').select2({
        //placeholder: placeholder
    });


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
