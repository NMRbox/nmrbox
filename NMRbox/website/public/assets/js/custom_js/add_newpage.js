$(document).ready(function() {
    /*csrf token */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
