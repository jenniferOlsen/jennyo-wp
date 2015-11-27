<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

?>
    <section class="smartlib-content-section container">
        <?php while (have_posts()) : the_post(); ?>

            <?php do_action('smartlib_breadcrumb'); ?>
            <header class="smartlib-box-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div id="page" role="main"
                 class="<?php echo bstarter__f('smartlib_content_layout_class', 'smartlib-left-content', 'blog_single') ?>">

                <?php

                get_template_part('views/content', 'single');

                ?>
                <?php do_action('smartlib_prev_next_post_navigation'); ?>

                <?php smartlib_get_related_post_box(8, 4); ?>

                <?php comments_template('', true); ?>


            </div><!-- END #page -->
        <?php endwhile; // end of the loop. ?>
        <?php do_action('smartlib_get_layout_sidebar', 'blog_single');//display homepage sidebar ?>

    </section>
<?php get_footer(); ?>