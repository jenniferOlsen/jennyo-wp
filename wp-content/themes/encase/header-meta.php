<section id="header-meta" class="clearfix">
	<div class="wrap clearfix">
		<?php if ( is_archive() ) : ?>
			<h1>
			<?php
				if ( is_category() ) {
					printf( __( 'Category: %s', 'encase' ), single_cat_title( '', false ) );
				} elseif ( is_tag() ) {
				    printf( __( 'Tagged: %s', 'encase' ), single_tag_title( '', false ) );
				} elseif ( is_author() ) {
					$curauth = get_queried_object();
					echo get_avatar( get_the_author_meta('email'), '90', get_the_author() );
					echo $curauth->display_name;
				} elseif ( is_day() ) {
				    printf( __( 'Day: %s', 'encase' ), get_the_date() );
				} elseif ( is_month() ) {
				    printf( __( 'Month: %s', 'encase' ), get_the_date( 'F Y' ) );
				} elseif ( is_year() ) {
				    printf( __( 'Year: %s', 'encase' ), get_the_date( 'Y' ) );
				} else {
				    _e( 'Archives', 'encase' );
				}
			?>
			</h1>

			<?php if ( is_category() && category_description( $category ) ) : ?>

				<h2><?php echo category_description(); ?></h2>

			<?php elseif ( is_author( $author ) ) : ?>

				<h2><?php the_author_meta( 'description' ); ?></h2>

			<?php endif; ?>
		
		<?php elseif ( is_search() ) : ?>
						
			<h1><?php _e( 'Search results for', 'encase' ) ?>: '<?php the_search_query(); ?>'</h1>

		<?php elseif ( is_404() ) : ?>

			<h1><?php _e( 'Page Not Found', 'encase' ) ?></h1>

		<?php else :
				if (get_the_excerpt()) { ?>		
					<h1><?php single_post_title(); ?></h1>
		<?php 	} else { ?>
					<h1 class = "excerpt-null"><?php single_post_title(); ?></h1>

		<?php 	} ?>
			<?php if ( !is_archive() && !is_search() && !is_404() ) : ?>
			
				<?php $page_id = get_queried_object_id(); ?>
				<h2><?php echo get_post_field( 'post_excerpt', $page_id, 'display' ); ?></h2>
			
			<?php endif;?>
							
		<?php endif; ?>
	</div>
</section>