/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function ($) {


// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
    var bstarter = {
        // All pages
        common: {
            init: function () {

                this.expandNavbarOnClickSearch();
                this.animateSection($('.smartlib-animate-object'));
                this.counterUp($('.smartlib-counter'));
                this.add_pretty_photo_gallery();//add pretty photo gallery
                this.addParalaxEffect();
                this.displayGooleMap(); //add google maps
                this.add_flexy_slider();
                this.scrollToElement();
                this.scrollToTop();
                /*responsive section on load document*/
                this.responsive_section();
            },


            animateSection: function (items, trigger) {
                items.each(function () {
                    var osElement = $(this),
                        osAnimationClass = osElement.attr('data-os-animation'),
                        osAnimationDelay = osElement.attr('data-os-animation-delay');

                    osElement.css({
                        '-webkit-animation-delay': osAnimationDelay,
                        '-moz-animation-delay': osAnimationDelay,
                        'animation-delay': osAnimationDelay
                    });


                    /*add opacity 0 to all animated sections - if css animations are supported*/
                    if (typeof osAnimationClass !== typeof undefined && osAnimationClass !== false && Modernizr.cssanimations !== false) {
                        osElement.css({
                            'opacity': 0
                        });
                    }

                    var osTrigger = ( trigger ) ? trigger : osElement;

                    osTrigger.waypoint(function () {
                        osElement.addClass('animated').addClass(osAnimationClass);
                    }, {
                        triggerOnce: true,
                        offset: '80%'
                    });
                });
            },
            counterUp: function (cunterObj) {

                if (cunterObj.length > 0) {

                    //reset box value
                    cunterObj.text(0);

                    cunterObj.waypoint(function () {

                        if (!cunterObj.hasClass('smartlib-counter-end')) {
                            cunterObj.countTo({speed: 2100});
                            cunterObj.addClass('smartlib-counter-end');
                        }
                    }, {
                        offset: '90%'
                    });

                }

            },
            expandNavbarOnClickSearch: function () {
                $('.smartlib-navbar-search-form .smartlib-search-btn').on('click', function (e) {

                    var form_container = $('.smartlib-navbar-search-form');
                    if (!form_container.hasClass('smartlib-expanded-search-form')) {
                        form_container.addClass('smartlib-expanded-search-form animated flipInX');

                        e.preventDefault();
                    }

                });
                $('.smartlib-navbar-search-form .smartlib-search-close-form').on('click', function (e) {

                    var form_container = $('.smartlib-navbar-search-form');
                    if (form_container.hasClass('smartlib-expanded-search-form')) {

                        form_container.removeClass('smartlib-expanded-search-form animated flipInX');
                    }
                    e.preventDefault();
                });


            },
            responsive_section: function () {

                var window_width = $(window).width();


                $('.smartlib-responsive-section').each(function (index) {
                    var section_container = $(this);
                    var propotions = section_container.attr('data-proportions');

                    if (typeof propotions !== typeof undefined && propotions !== false) {
                        section_container.height(window_width * propotions);
                    }
                });


            },




            add_pretty_photo_gallery: function () {

                if ($("a[rel^='smartlib-resize-photo']").length > 0) {

                    $("a[rel^='smartlib-resize-photo']").prettyPhoto();
                }

            },
            add_flexy_slider: function () {

                var $slider = $('.smartlib-slider-container');

                if ($slider.length > 0) {

                    $slider.each(function () {
                            $(this).flexslider();

                    })
                }

            },

            addParalaxEffect: function () {

                // cache the window object
                $window = $(window);

                $('div[data-type="background"]').each(function () {
                    // declare the variable to affect the defined data-type
                    var $scroll = $(this);
                    var bg_color = $scroll.attr('data-overlay-color');

                    //get rgb color

                    var patt = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
                    var matches = patt.exec(bg_color);
                    if(matches){
                        var rgba = "rgba("+parseInt(matches[1], 16)+","+parseInt(matches[2], 16)+","+parseInt(matches[3], 16)+","+0.8+")";

                        //set rgb color
                        $scroll.css('background-color', rgba);
                    }


                });  // end section function

            },

            scrollToElement: function(){

                $('body').scrollspy({ target: '#smartlib-spy-scroll-nav', offset: 50 });

                $("#smartlib-one-page-menu a").on('click', function (){





                    var $container =  $(this);
                    var $parent_container = $container.parents('#smartlib-one-page-menu');
                    var containerTo = $container.attr('href');
                    var offset = 1* $parent_container.data('scroll-offset');




                    $('html, body').animate({
                        scrollTop: $(containerTo).offset().top - offset
                    }, 2000);

                });

            },

            scrollToTop: function(){

                $btnTop = $('#scroll-top-top');

                //Check to see if the window is top if not then display button
                $(window).scroll(function(){
                    if ($(this).scrollTop() > 100) {
                        $btnTop.addClass('slideInUp');
                    } else {
                        $btnTop.removeClass('slideInUp');
                    }
                });

                //Click event to scroll to top
                $btnTop.click(function(){
                    $('html, body').animate({scrollTop : 0},800);
                    return false;
                });

            },
            displayGooleMap: function () {

                if ($('.smrtlib-google-maps').length > 0) {

                    $('.smrtlib-google-maps').each(function () {
                        var containerMap = $(this);
                        var markers = containerMap.find('.smartlib-map-marker');

                        var map = new GMaps({
                            scrollwheel: false,
                            div: '#' + containerMap.attr('id'),
                            zoom: containerMap.data('zoom'),
                            lat: containerMap.data('lat'),
                            lng: containerMap.data('long')
                        });


                        if (markers.length > 0) {

                            markers.each(function () {
                                var marker = $(this);

                                map.addMarker({
                                    lat: marker.data('lat'),
                                    lng: marker.data('long'),
                                    title: marker.data('text'),
                                    infoWindow: {
                                        content: '<p>' + marker.data('text') + '</p>'
                                    }

                                });
                            });
                        }

                    });
                }

            }

        },
        // Home page
        home: {
            init: function () {
                // JavaScript to be fired on the home page
            }
        },
        // About us page, note the change from about-us to about_us.
        about_us: {
            init: function () {
                // JavaScript to be fired on the about us page
            }
        },
        page_portfolio_isotope:{
            init: function () {
                this.portfolio_filter(); //add google maps

            },

            portfolio_filter: function () {

                var $portfolioContainer = $('.smartlib-layout-isotope-list');



                if($portfolioContainer.length>0){
                    $portfolioContainer.shuffle('shuffle');
                    $('.smartlib-sort-source li a').on('click', function (e) {
                        e.preventDefault();

                        $('.smartlib-sort-source li a').removeClass('smartlib-active-filter');

                        var isActive = $(this).hasClass( 'smartlib-active-filter' );
                        $(this).addClass('smartlib-active-filter');

                        var group = isActive ? 'all' :$(this).data('group');

                        $portfolioContainer.shuffle('shuffle', group );
                    });
                }
            }
        }
    };

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var namespace = bstarter;
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

    /*fire functions on window resize*/
    $(window).resize(function () {
        bstarter.common.responsive_section();
    });

    $(window).load(function () {
        smartlib_preloader()
    });

    //helper functions

    function slider_animations() {


        /*  $('.smartlib-main-slider .smartlib-to-animate').each(
         function(){
         console.log($(this).attr('data-delay'))
         }
         )*/
    }

    function smartlib_preloader() {

        imageSources = []
        $('img').each(function () {
            var sources = $(this).attr('src');
            imageSources.push(sources);
        });
        if ($(imageSources).load()) {
            $('.smartlib-pre-loader').fadeOut('slow');
        }
    }

    /*Fix double click Ipad*/

    $('body').on('touchstart','*',function(){   //listen to touch
        var jQueryElement=$(this);
        var element = jQueryElement.get(0); // find tapped HTML element
        if(!element.click){
            var eventObj = document.createEvent('MouseEvents');
            eventObj.initEvent('click',true,true);
            element.dispatchEvent(eventObj);
        }
    });
})(jQuery); // Fully reference jQuery after this point.
