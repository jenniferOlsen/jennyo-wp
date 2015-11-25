<?php
/**
 * @package Next_Saturday
 */

// Define common regex lookup patterns
if ( ! defined( 'WPCOM_THEMES_IMAGE_REGEX' ) )
	define( 'WPCOM_THEMES_IMAGE_REGEX', '/(<img.+src=[\'"]([^\'"]+)[\'"].*?>)/i' );
if ( ! defined( 'WPCOM_THEMES_IMAGE_REPLACE_REGEX' ) )
	define( 'WPCOM_THEMES_IMAGE_REPLACE_REGEX', '/\[caption.*\[\/caption\]|<img[^>]+./' );

if ( ! function_exists( 'next_saturday_url_grabber' ) ) :
/**
 * Return the URL for the first link found in this post.
 *
 * @param string $the_content Post content, falls back to current post content if empty.
 * @return boolean|string URL or false when no link is present.
 */
function next_saturday_url_grabber( $the_content = '' ) {
	if ( empty( $the_content ) )
		$the_content = make_clickable( get_the_content() );

	if ( function_exists( 'get_url_in_content' ) )
		return get_url_in_content( $the_content );

	if ( preg_match( '/<a\s[^>]*?href=([\'"])(.+?)\1/is', $the_content, $matches ) )
		return esc_url_raw( $matches[1] );

	return '';
}
endif; // if ( ! function_exists( 'next_saturday_url_grabber' ) )

if ( ! function_exists( 'next_saturday_image_grabber' ) ) :
/**
 * Return the HTML output for first image found for a post.
 *
 * @param int $post_id ID for parent post.
 * @param string $the_content
 * @param string $before Optional before string.
 * @param string $after Optional after string.
 * @return boolean|string HTML output or false if no match.
 */
function next_saturday_image_grabber( $post_id, $the_content = '', $before = '', $after = '' ) {
	global $wpdb;
	$image_src = '';
	if ( empty( $the_content ) )
		$the_content = get_the_content();

	$first_image = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'attachment' AND INSTR(post_mime_type, 'image') ORDER BY menu_order ASC LIMIT 0,1", (int) $post_id ) );

	if ( ! empty( $first_image ) ) {
		// We have an attachment, so just use its data.
		$image_src = wp_get_attachment_image( $first_image, 'image' );
	} else {
		// Try to get the image for the linked image (not attached)
		$output = preg_match( WPCOM_THEMES_IMAGE_REGEX, $the_content, $matches );
		if ( isset( $matches[0] ) )
			$image_src = $matches[0];
	}

	if ( ! empty( $image_src ) ) {
		// Add wrapper markup, if specified
		if ( ! empty( $before ) )
			$image_src = $before . $image_src;
		if ( ! empty( $after ) )
			$image_src = $image_src . $after;

		return $image_src;
	}

	return false;
}
endif; // if ( ! function_exists( 'next_saturday_image_grabber' ) )

if ( ! function_exists( 'next_saturday_audio_grabber' ) ) :
/**
 * Return the first audio file found for a post.
 *
 * @param int $post_id ID for parent post.
 * @return boolean|string Path to audio file.
 */
function next_saturday_audio_grabber( $post_id ) {
	if ( function_exists( 'get_attached_media' ) )
		return array_shift( get_attached_media( 'audio', $post_id ) );

	$audios = get_children( array(
		'post_parent'    => $post_id,
		'post_type'      => 'attachment',
		'post_mime_type' => 'audio',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );

	$audios = (array) apply_filters( 'get_attached_media', $audios, 'audio', get_post( $post_id ) );

	return array_shift( $audios );
}
endif; // if ( ! function_exists( 'next_saturday_audio_grabber' ) )
