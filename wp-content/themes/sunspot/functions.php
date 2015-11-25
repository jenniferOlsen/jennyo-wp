<?php
/**
 * Sunspot functions and definitions
 *
 * @package Sunspot
 * @since Sunspot 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Sunspot 1.0
 */
$options = get_option( 'sunspot_theme_options' );
$front_layout = $options['sunspot_radio_buttons'];

if ( ! isset( $content_width ) ) :
	if ( is_home() ) :
		if ( 'double' == $front_layout && is_active_sidebar( 'sidebar-1' ) ) :
			$content_width = 260;
		elseif ( 'single' == $front_layout && is_active_sidebar( 'sidebar-1' ) ) :
			$content_width = 545;
		elseif ( 'double' == $current_columns && ! is_active_sidebar( 'sidebar-1' ) ) :
			$content_width = 387;
		elseif ( 'single' == $current_columns && ! is_active_sidebar( 'sidebar-1' ) ) :
			$content_width = 824;
		endif;
	else:
		if ( is_active_sidebar( 'sidebar-1' ) ) :
			$content_width = 545;
		else :
			$content_width = 824;
		endif;
	endif;
endif;


if ( ! function_exists( 'sunspot_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Sunspot 1.0
 */
function sunspot_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change 'sunspot' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sunspot', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sunspot' ),
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background' );

	/**
	 * Add support for featured thumbnail images
	 */
	add_theme_support( 'post-thumbnails' );

	// We'll be using post thumbnails on the front page, search results and archive pages.
	// "sunspot-thumbnail-wide" is used when sidebar-1 does not contain widgets.
	add_image_size( 'sunspot-thumbnail', 260, 160, true );
	add_image_size( 'sunspot-thumbnail-wide', 387, 160, true );

}
endif; // sunspot_setup
add_action( 'after_setup_theme', 'sunspot_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Sunspot 1.0
 */
function sunspot_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'sunspot' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'sunspot' ),
		'description' => __( 'Widgets in this sidebar will not be displayed on small screens.', 'sunspot' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'sunspot_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function sunspot_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	if ( is_singular() && wp_attachment_is_image( get_post()->ID ) )
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
}
add_action( 'wp_enqueue_scripts', 'sunspot_scripts' );

/**
 * Register Google Fonts style.
 *
 * @since Sunspot 1.0
 */
function sunspot_register_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_register_style(
		'ubuntu',
		"$protocol://fonts.googleapis.com/css?family=Ubuntu:400,300",
		array(),
		'20120821'
	);
}
add_action( 'init', 'sunspot_register_fonts' );

/**
 * Enqueue Sunspot Fonts
 *
 * @since Sunspot 1.0
 */
function sunspot_fonts() {
	wp_enqueue_style( 'ubuntu' );
}
add_action( 'wp_enqueue_scripts', 'sunspot_fonts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Sunspot 1.0
 */
function sunspot_admin_fonts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'ubuntu' );
}
add_action( 'admin_enqueue_scripts', 'sunspot_admin_fonts' );

/**
 * Implement the Custom Header feature
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Load Jetpack compatibility file.
 */
if ( file_exists( get_template_directory() . '/inc/jetpack.php' ) )
	require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/tweaks.php';

/**
 * Custom Theme Options
 */
require get_template_directory() . '/inc/theme-options/theme-options.php';
