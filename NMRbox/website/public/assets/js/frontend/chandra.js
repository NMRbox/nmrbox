
//Back to top code
$(document).ready(function(){
     $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('#back-to-top').tooltip('show');

    //menu hover dropdown
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
            $(this).toggleClass('open');
        }
    );

    $("#notifications-box").fadeTo(5000, 500).slideUp(500, function(){
        $("#notifications-box").slideUp(500);
    });
});

/* alert box */
function show_alert(alert_type, fade) {
    $("#"+alert_type+"-alert").removeClass('hidden');
    $("#"+alert_type+"-alert").alert();
    if(fade != 'no'){
        $("#"+alert_type+"-alert").fadeTo(5000, 500).slideUp(500, function(){
            $("#"+alert_type+"-alert").slideUp(500);
        });
    }
}