<?php
/**
 * The template for displaying Archive pages.
 */

get_header();
?>
	<section class="smartlib-content-section container">
		<?php do_action('smartlib_breadcrumb'); ?>
		<header class="archive-header smartlib-above-content-header">
			<h1 class="archive-title"><?php
				if (is_day()) :
					printf(__('Daily Archives: %s', 'bootframe-core'), '<span>' . get_the_date() . '</span>'); elseif (is_month()) :
					printf(__('Monthly Archives: %s', 'bootframe-core'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'bootframe-core')) . '</span>');
				elseif (is_year()) :
					printf(__('Yearly Archives: %s', 'bootframe-core'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'bootframe-core')) . '</span>');
				else :
					_e('Archives', 'bootframe-core');
				endif;
				?></h1>

			<?php if (category_description()) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
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