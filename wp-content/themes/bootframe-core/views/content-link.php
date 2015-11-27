<?php
/**
 * The template for displaying posts in the Link post format
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'smartlib-content-area smartlib-link-area' ); ?>>
	<header class="smartlib-post-header entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php do_action( 'smartlib_display_meta_post', 'blog_single' ); ?>
	</header>
	<?php smartlib_post_thumbnail( 'smartlib-content-wide' ); ?>
	<div class="smartlib-single-content entry-content">
		<?php the_content(); ?>
	</div>
	<?php do_action( 'smartlib_custom_single_page_pagination' ); ?>
	<footer class="smartlib-footer-meta entry-meta">
		<?php
		do_action( 'smartlib_social_links_area' );
		?>
	</footer>
</article>

