<?php
/**
 Sticky Post Slider Template
 */
?>
<li>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>
		<div class="col-md-10 smartlib-slider-image-column">
			<?php

			if ( '' != get_the_post_thumbnail() ) {
				?>
				<div class="smartlib-featured-image-container">

					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'wide-image' ); ?></a>

				</div>
				<?php
			}
			?>


		</div>
		<div class="col-md-6">

			<div class="smartlib-featured-post-box">
				<?php  do_action( 'smartlib_author_line' ); ?>
				<header class="entry-header">
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>"
							 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'bootframe-core' ), the_title_attribute( 'echo=0' ) ) ); ?>"
							 rel="bookmark"><?php the_title(); ?></a>
					</h3>
					<?php do_action( 'smartlib_display_meta_post', 'default' ); ?>
				</header>
			</div>
		</div>
	</article>

</li>