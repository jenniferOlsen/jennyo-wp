<?php
/**
 * Template Name: One Page
 *
 */

$page_children = new WP_Query(array(

    'post_parent' => $post->ID,
    'post_type' => 'page',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => -1

));

require locate_template('header.php'); ?>

    <div class="smartlib-page-blocks" id="smartlib-one-page-area">

        <?php

            while(have_posts()):the_post();

                the_content();

            endwhile;



        if ($page_children->have_posts()) : ?>

            <?php while ($page_children->have_posts()) : $page_children->the_post(); ?>

                <div id="smartlib-page-<?php the_ID(); ?>" class="smartlib-subpage-section">

                    <?php the_content() ?>

                </div>

            <?php endwhile; ?>

            <?php unset($page_children); endif;
        wp_reset_query(); ?>

    </div>
<?php get_footer(); ?>