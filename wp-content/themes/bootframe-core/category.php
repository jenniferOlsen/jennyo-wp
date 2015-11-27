<?php
/**
 * The template for displaying Category pages.
 */

get_header();
?>
    <section class="smartlib-content-section container">
        <?php do_action('smartlib_breadcrumb'); ?>
        <header class="archive-header smartlib-above-content-header">
            <h1 class="archive-title"><small><?php printf(__('Category Archives: %s', 'bootframe-core'), '</small><span>' . single_cat_title('', false) . '</span>'); ?></h1>

            <?php if (category_description()) : // Show an optional category description ?>
                <div class="archive-meta"><?php echo category_description(); ?></div>
            <?php endif; ?>
        </header>
        <!-- .archive-header -->
    </section>
<section class="smartlib-content-section container">

    <div id="page" role="main"
         class="<?php echo apply_filters('smartlib_content_layout_class', 'col-sm-16 col-md-12', 'blog_loop') ?>">

        <?php if (have_posts()) : ?>

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


    </div>
    <!-- END #page -->

<?php
do_action('smartlib_get_layout_sidebar', 'blog_loop');
?>
</section>
<?php get_footer(); ?>