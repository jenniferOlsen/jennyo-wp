<?php
/**
 * Compatibility settings and functions for Jetpack from Automattic.
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Sunspot
 */

/**
 * Add support for Infinite Scroll.
 */
function sunspot_infinite_scroll_init() {
	$options = get_option( 'sunspot_theme_options' );
	$is_args = array(
		'container'  => 'content',
		'footer'     => 'wrapper',
	);

	// if the user is showing the double column posts layout on the front page.
	if ( 'double' == $options['sunspot_radio_buttons'] ) {
		$is_args['render']         = 'sunspot_infinite_scroll_render';
		$is_args['posts_per_page'] = 6;
	}

	add_theme_support( 'infinite-scroll', $is_args );
}
add_action( 'after_setup_theme', 'sunspot_infinite_scroll_init' );

/**
 * Custom infinite scroll render function, to allow IS for double column layout.
 */
function sunspot_infinite_scroll_render() {
	$count       = 0;     // Set up a variable to count the number of posts so that we can break them up into rows.
	$column_type = 'odd'; // Set up a variable to add a CSS class to the post columns.

	if ( have_posts() ) : ?>

		<div class="post-row clearfix">

		<?php while ( have_posts() ) :
			the_post();
			$count++;
			$column_type = ( $count % 2 == 0 ) ? 'even-col' : 'odd-col';
		?>
			<div class="post-column <?php echo $column_type; ?>">
				<?php
					// Include the Post-Format-specific template for the content.
					get_template_part( 'content-two-col', get_post_format() );
				?>
			</div><!-- .post-column -->

		<?php if ( $count % 2 == 0 ) : // After every other post, end the row and start a new one. ?>
		</div><!-- .post-row -->
		<div class="post-row clearfix">
		<?php endif; ?>

		<?php endwhile; // end of the loop ?>
		</div><!-- .post-row -->

	<?php endif;
}
