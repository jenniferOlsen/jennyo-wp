var bstarter_admin = null;
(function ($) {
// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
    bstarter_admin = {
        // All pages
        common: {
            init: function () {

            },
            click_manager_init: function(button){
                this.smartlib_media_init(button);
                return false
            },
            smartlib_media_init: function (button_selector) {
                var clicked_button = false;
                        var selected_img;
                        clicked_button = button_selector;

                        // check for media manager instance
                        if (wp.media.frames.gk_frame) {
                            wp.media.frames.gk_frame.open();
                            return;
                        }
                        // configuration of the media manager new instance
                        wp.media.frames.gk_frame = wp.media({
                            title: 'Select image',
                            multiple: false,
                            library: {
                                type: 'image'
                            },
                            button: {
                                text: 'Use selected image'
                            }
                        });

                        // Function used for the image selection and media manager closing
                        var gk_media_set_image = function () {
                            var selection = wp.media.frames.gk_frame.state().get('selection');

                            // no selection
                            if (!selection) {
                                return;
                            }

                            // iterate through selected elements
                            selection.each(function (attachment) {
                                var url = attachment.attributes.url;


                                $(clicked_button).prev('.smartlib-media-input').val(url);
                                $(clicked_button).next('.smartlib-image-area').html('<div class="smartlib-widget-image-area"><img src="'+url+'" />')
                            });
                        };

                        // closing event for media manger
                        wp.media.frames.gk_frame.on('close', gk_media_set_image);
                        // image selection event
                        wp.media.frames.gk_frame.on('select', gk_media_set_image);
                        // showing media manager
                        wp.media.frames.gk_frame.open();




}

    }
    }
        var UTIL = {
            fire: function (func, funcname, args) {
                var namespace = bstarter_admin;
                funcname = (funcname === undefined) ? 'init' : funcname;
                if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
                    namespace[func][funcname](args);
                }
            },
            loadEvents: function () {
                UTIL.fire('common');

                $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                    UTIL.fire(classnm);
                });
            }
        };

    $(document).ready(UTIL.loadEvents);

})(jQuery);





