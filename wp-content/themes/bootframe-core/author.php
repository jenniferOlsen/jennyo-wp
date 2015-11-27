<?php
/**
 * The template for displaying Archive pages.
 */

get_header();
?>
	<section class="smartlib-content-section container">
		<?php do_action('smartlib_breadcrumb'); ?>
		<header class="archive-header smartlib-above-content-header">
			<h1 class="archive-title">
				<?php printf(__('Author Archives: %s', 'bootframe-core'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta("ID"))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?>
			</h1>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="smartlib-author-info">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'smartlib_author_bio_avatar_size', 68 ) ); ?>
					<!-- .author-avatar -->
					<div class="smartlib-author-description">
						<h3><?php printf( __( 'About %s', 'bootframe-core' ), get_the_author() ); ?></h3>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>
					<!-- .author-description	-->
				</div><!-- .author-info -->
			<?php endif; ?>
		</header><!-- .archive-header -->
	</section>
<?php if (have_posts()) : ?>

	<section class="smartlib-content-section container">
	<div id="page" role="main" class="<?php echo apply_filters('smartlib_content_layout_class', 'col-sm-16 col-md-12', 'blog_loop') ?>">
	<?php
	/* Start the Loop */
	while (have_posts()) : the_post();
		get_template_part('views/content-loop', smartlib_get_loop_variant());
	endwhile;
	?>

	<?php
	smartlib_list_pagination('nav-below');
	?>

<?php else : ?>
	<?php get_template_part('views/content', 'none'); ?>
<?php endif; ?>


	</div><!-- #page -->

<?php do_action('smartlib_get_layout_sidebar', 'blog_loop'); ?>
</section>

<?php get_footer(); ?>