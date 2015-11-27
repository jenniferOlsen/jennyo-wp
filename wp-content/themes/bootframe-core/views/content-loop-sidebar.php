<?php
/**
 * The default template for displaying content in loop - template with sidebar.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('smartlib-article-box smartlib-article-wide-box'); ?>>

    <?php smartlib_post_thumbnail_block('smartlib-content-wide', 'blog_loop') ?>

    <div class="smartlib-content-container">
    <header class="entry-header">
        <h3 class="entry-title">
            <a href="<?php the_permalink(); ?>"
               title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'bootframe-core'), the_title_attribute('echo=0'))); ?>"
               rel="bookmark"><?php the_title(); ?></a>
        </h3>
        <?php smartlib_meta_post() ?>

    </header>

    <div class="smartlib-entry-content entry-content">
        <?php the_content(); ?>
    </div>
    <!-- .entry-content -->
    <?php smartlib_box_footer(); ?>
    </div>
    <!-- END smartlib-content-container -->
</article>

