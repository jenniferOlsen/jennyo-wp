<?php get_header(); ?>

	<div class="all-content wrap clearfix">

		<main id="content" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<!-- Article -->
				<article <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

					<?php 
						$format = get_post_format(); 
						get_template_part( 'content', $format );
					?>

				</article>

			<?php endwhile; ?>

				<?php if ( $wp_query->max_num_pages > 1 ) : ?>

					<!--Pagination-->
					<div class="pagination">

						<?php if( function_exists( 'wp_pagenavi' ) ) : ?>

							<?php wp_pagenavi(); ?>

						<?php else : ?>

							<?php next_posts_link( '<span>&larr;</span> '.__('Older Posts', 'encase').'' ); ?>
							<?php previous_posts_link( __( 'Newer Posts', 'encase' ).' <span>&rarr;</span>' ); ?>

						<?php endif; ?>

					</div>

				<?php endif; ?>

			<?php else : ?>

				<?php _e( 'Your search did not match any entries', 'encase' ) ?>

			<?php endif; ?>
		
		</main>

		<!--Sidebar-->
		<aside id="sidebar" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'sidebar-blog' ); ?>
		</aside>
	
	</div>
			
<?php get_footer(); ?>
