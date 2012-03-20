(function($) {
    $('#gsrm-top-menu > li.current-menu-item > a').on('click', function(e){
        $('#gsrm-sub-menu > .current-menu-item').slideToggle();
        e.preventDefault();
    });

})(jQuery);