<?php
/**
 * The Left Sidebar for the blog and pages
 * @package flat-responsive
 * @since 1.0.0
 */

if (   ! is_active_sidebar( 'pageleft'  )
	&& ! is_active_sidebar( 'blogleft' ) 
	)
	return;

if ( is_page() ) {
	dynamic_sidebar( 'pageleft' );
} else {
	dynamic_sidebar( 'blogleft' );
}
?>