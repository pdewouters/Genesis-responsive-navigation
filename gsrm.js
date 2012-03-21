(function($) {
    $('#gsrm-top-menu > li.current-menu-item > a').on('click', function(e){
        $('#gsrm-sub-menu > .current-menu-item').slideToggle();
        e.preventDefault();
    });
    
    $('div.menu-wrap h2 a').on('click', function(e){
        $('ul#gsrm-top-menu').slideToggle();
        e.preventDefault();
    });    

})(jQuery);