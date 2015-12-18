
jQuery(document).ready(function($) {

    //Move To Top
    var window_height = jQuery(window).height();
    var window_height = (window_height) + (50);
    
    

    jQuery(window).scroll(function() {
        var scroll_top = $(window).scrollTop();
        if (scroll_top > window_height) {
            jQuery('.encase_move_to_top').show();
        }
        else {
            jQuery('.encase_move_to_top').hide();   
        }
    });

});