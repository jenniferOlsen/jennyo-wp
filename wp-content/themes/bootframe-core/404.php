<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

?>
	<section class="smartlib-content-section container">

			<header class="smartlib-box-header">
				<h1 class="entry-title">404</h1>
			</header>

			<div id="page" role="main"
				 class="smartlib-no-sidebar">

				<div class="smartlib-page-container">
					<p><?php _e('Apologies, but no results were found. Perhaps searching will help find a related post.', 'bootframe-core'); ?></p>
					<div class="row">
						<div class="col-sm-6"><?php get_search_form(); ?></div>
					</div>
				</div>


			</div><!-- END #page -->

	</section>
<?php get_footer(); ?>