<?php get_header(); ?>

	<div class="wrap clearfix">


		<main id="content" role="main" itemprop="mainContentOfPage">

			<?php while ( have_posts() ) : the_post(); ?>

				<!-- Article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

					<div class="entry-content" itemprop="text">
						<?php the_content(); ?>
					</div>

					<?php wp_link_pages( array( 'before' => '<nav class="pagination">', 'after' => '</nav>' ) ); ?>

				</article>

			<?php endwhile; ?>
		
		</main>

		<!--Sidebar-->
		<?php get_sidebar(); ?>

	</div>
			
<?php get_footer(); ?>
