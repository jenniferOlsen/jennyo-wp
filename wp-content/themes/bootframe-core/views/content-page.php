<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'smartlib-page-container' ); ?> >

	<header class="smartlib-page-header">
		<h1>
			<?php the_title() ?>
			<small><?php echo smartlib_get_subtitle() ?></small>
		</h1>

	</header>
	<div class="smartlib-thumbnail-outer">
		<?php smartlib_post_thumbnail( 'full' );	?>
	</div>

	<div class="smartlib-content-container entry-content">
		<?php the_content(); ?>
		<?php do_action( 'smartlib_custom_single_page_pagination' ); ?>
	</div>

</article>


