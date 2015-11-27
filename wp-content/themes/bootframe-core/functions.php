<?php

// Load Smart Library

require_once locate_template('/smart-lib/init.php' );
require_once locate_template('/smart-lib/classes/smartlib-factory.php' );

require_once locate_template('/smart-lib/activation.php' );//Theme activation page


//Initialize Smartlib Library

__SMARTLIB::init();


/**
 * Sets up theme defaults and registers the various WordPress features
 */

function bootframe_core_setup(){
    /*
             * Load textdomain.
             */
    load_theme_textdomain('bootframe-core', get_template_directory() . '/languages');

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme supports a variety of post formats.
    add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status', 'video',  'gallery'));

    // add custom header suport
    $args = array(

        'uploads' => true,
        'header-text' => false
    );
    add_theme_support('custom-header', $args);

	if ( ! isset( $content_width ) ) $content_width = 1200;

    //Register nav menus

	if(count(__SMARTLIB::config()->project_menus)>0) {
		foreach(__SMARTLIB::config()->project_menus as $id => $name) {
			register_nav_menu($id, $name);
		}
	}
	/* initialize options*/



	  /*register sidebars form config class*/
	  if(count(__SMARTLIB::config()->project_sidebars)>0){
			foreach(__SMARTLIB::config()->project_sidebars as $id => $sidebar){
				$args = array(
					'name'          => $sidebar['name'],
					'id'            => $id,
					'description'   => $sidebar['description'],
					'before_widget' => $sidebar['before_widget'],
					'after_widget'  => $sidebar['after_widget'],
					'before_title'  => $sidebar['before_title'],
					'after_title'   => $sidebar['after_title']
				);
				register_sidebar( $args );
			}
		}

    /*
                 * This theme supports custom background color and image, and here
                 * we also set up the default background color.
                 */
    add_theme_support('custom-background', array(
                                                'default-color' => 'fff',
                                           ));
	  add_theme_support('shortcode');


	/**
     * POSTS THUMBNAILS
     */
    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
	add_image_size('smartlib-small-square', 100, 100, true);
    add_image_size('smartlib-medium-square', 200, 200, true);
	add_image_size('smartlib-medium-thumb', 250, 180, true);
	add_image_size('smartlib-large-thumb', 500, 400, true);
	add_image_size('smartlib-medium-image-portfolio', 700, 460, true);
	add_image_size('smartlib-content-wide', 1000, 520, true);
  	add_image_size('smartlib-content-medium', 350, 250, true);
	add_image_size('col-sm-square', 350, 350, true);


	/**
	 * Add title tag support
	 */
	add_theme_support( 'title-tag' );


}

add_action('after_setup_theme', 'bootframe_core_setup');

/* add smartlib scripts - smart-lib scripts.php */
//add_action('wp_enqueue_scripts', 'smartlib_scripts', 10);






/**

 */
if( !function_exists( 'bstarter__f' )) :
	function bstarter__f ( $tag , $value = null , $arg_one = null , $arg_two = null , $arg_three = null , $arg_four = null , $arg_five = null) {

		return apply_filters( $tag , $value , $arg_one , $arg_two , $arg_three , $arg_four , $arg_five );
	}
endif;

