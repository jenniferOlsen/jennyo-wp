<?php
/**
 * Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package encase 
 */

function encase_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'encase_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/images/banner-1.jpg',
		'random-default'         => false,
		'flex-width'    		 => true,
		'width'                  => 2560,
		'flex-height'            => true,
		'height'                 => 500,	
		'uploads'       		 => true,
		'header-text'            => false,
		'admin-preview-callback' => 'encase_admin_header_image'
	) ) );
        
    //register the derault header
    register_default_headers( array(
        'mypic' => array(
        'url'   => get_template_directory_uri() . '/images/banner-1.jpg',
        'thumbnail_url' => get_template_directory_uri() . '/images/banner-1.jpg',
        'description'   => _x( 'Default Header', 'Default Header', 'encase' )),
    ));    
}
add_action( 'after_setup_theme', 'encase_custom_header_setup' );

if ( ! function_exists( 'encase_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see encase_custom_header_setup().
 */
	function encase_admin_header_image() { ?>
		<div id="headimg">
			<?php if ( get_header_image() ) : ?>
				<img src="<?php header_image(); ?>" alt="">
			<?php endif; ?>
		</div>
  <?php 
    }
endif; // encase_admin_header_image