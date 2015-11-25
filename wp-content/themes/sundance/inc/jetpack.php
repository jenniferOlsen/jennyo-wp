<?php
/**
 * Compatibility settings and functions for Jetpack from Automattic
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Sundance
 */

function sundance_jetpack_init() {
	/**
	 * Add theme support for Infinite Scroll.
	 */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'content',
		'footer'         => 'primary',
	) );

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'sundance_jetpack_init' );