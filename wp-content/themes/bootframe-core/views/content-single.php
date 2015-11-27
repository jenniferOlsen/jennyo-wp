<?php
/**
 * The default template for displaying single content.

 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('smartlib-article-box'); ?>>

    <div class="smartlib-single-content-container">

        <?php smartlib_post_thumbnail_block('smartlib-content-wide', 'blog_single'); ?>
        <?php smartlib_meta_post('blog_single') ?>

        <div class="smartlib-content-container entry-content">
            <?php the_content(); ?>
        </div>
        <?php do_action('smartlib_custom_single_page_pagination'); ?>


        <?php do_action('smartlib_entry_tags', '') ?>
    </div>

    <?php smartlib_display_sidepanel() ?>

    <footer class="smrtlib-post-footer">
        <?php smartlib_display_author_box() ?>
    </footer>


</article>

