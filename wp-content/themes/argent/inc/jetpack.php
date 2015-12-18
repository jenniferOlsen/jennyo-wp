<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Argent
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function argent_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'wrapper' 		 => false,
		'footer_widgets' => array( 'sidebar-1', 'sidebar-2', 'sidebar-3' ),
		'container' 	 => 'main',
		'footer'    	 => 'page',
	) );

	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'jetpack-portfolio' );
}
add_action( 'after_setup_theme', 'argent_jetpack_setup' );

/**
 * Change Jetpack's Infinite Scroll text.
 */
function argent_infinite_scroll_js_settings( $settings ) {

	/**
	 * For the portfolio, change the wrapper id
	 */
	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		$settings['id'] = 'portfolio-wrapper';
	}

	return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'argent_infinite_scroll_js_settings' );

/**
 * Change the render if we are on the portfolio
 * archive or page template.
 */
function argent_infinite_scroll_render() {
	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'content', 'portfolio' );
		}
	}
}
add_action( 'infinite_scroll_render', 'argent_infinite_scroll_render' );
