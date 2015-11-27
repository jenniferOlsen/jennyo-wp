<?php
/**
 * BootFrame home template file.
 *
 *
 *
 * @since      BootFrame 1.0
 */

get_header(); ?>

<?php

smartlib_get_header(); //display header info or header image

?>
<section class="smartlib-content-section container">

	<div id="page" role="main" class="<?php echo bstarter__f('smartlib_content_layout_class', 'col-sm-16 col-md-12', 'frontpage' ) ?>">



		<?php
		while(have_posts()):the_post();
			get_template_part('views/content-loop', 'sidebar');
		endwhile;
		?>
		<?php
		smartlib_list_pagination('nav-below');
		?>

	</div><!-- #page -->
	<?php do_action('smartlib_get_layout_sidebar', 'frontpage_content');//display homepage sidebar ?>
</section>
<?php get_footer(); ?>
