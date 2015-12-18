<?php
/**
 * Archives template
 *
 * @package    Modern Child
 * @copyright  2015 Jenny Olsen
 *
 * @since    1.0
 * @version  1.2
 */



get_header();

	?>

	<section class="archives-listing">

		<?php get_template_part( 'loop', 'archive' ); ?>

	</section>

	<?php

get_footer();

?>