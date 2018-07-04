(function ($) {
    // USE STRICT
    "use strict";
    //----------------------------------------------------/
    // Predefined Variables
    //----------------------------------------------------/
    var $window = $(window),
        $body = $('body'),
        $topSearch = $('#top-search'),
        $header = $('#header'),
        $headerCurrentClasses = $header.attr('class'),
        $goToTop = $('#goToTop');
    if ($header.length > 0) {
        var $headerOffsetTop = $header.offset().top;
    }
    //
    var scrollOffset = $body.attr('data-offset') || 600;
    $window.scroll(function () {
        if ($window.scrollTop() >= scrollOffset) {
            $goToTop.css({
                'bottom': '65px',
                'opacity': 1
            });
        }else {
            $goToTop.css({
                'bottom': '16px',
                'opacity': 0
            });
        }
    });
    $goToTop.click(function () {
        $('body,html').animate({ scrollTop: 0 }, 500);
        return false;
    });

    $("#top-search-trigger").on("click", function() {
        $body.toggleClass('top-search-active');
        $topSearch.find('input').focus();
        return false;
    });

    $("#mainMenu-trigger button").on('click touchend', function(e) {
        $body.toggleClass("mainMenu-open");
        $(this).toggleClass("toggle-active");
        if ($body.hasClass("mainMenu-open")) {
            $header.find("#mainMenu").css("max-height", $window.height() - $header.height());
        } else {
            $header.find("#mainMenu").css("max-height", 0);
        }
        return false;
    });
})(jQuery);
