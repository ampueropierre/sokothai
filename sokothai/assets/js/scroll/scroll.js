import $ from "jquery";

$(document).ready(function() {
    $('a[href*=\\#]:not([href=\\#])').bind('click', function(e) {
        e.preventDefault();

        var target = $(this).attr("href");

        $('html, body').stop().animate({
            scrollTop: $(target).offset().top
        }, 600, function() {
            location.hash = target;
        });

        return false;
    });

    $(window).scroll(function() {
        var scrollDistance = $(window).scrollTop();

        if (scrollDistance > 500) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });
});
