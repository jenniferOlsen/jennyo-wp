<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'smartlib-page-container' ); ?> >

	<div class="smartlib-thumbnail-outer">
		<?php smartlib_post_thumbnail( 'smartlib-content-wide' );	?>
	</div>

	<div class="smartlib-content-container entry-content">
		<?php the_content(); ?>
		<?php do_action( 'smartlib_custom_single_page_pagination' ); ?>
	</div>

</article>


