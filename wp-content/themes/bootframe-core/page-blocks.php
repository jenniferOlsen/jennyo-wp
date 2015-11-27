<?php
/**
 * Template Name: Page Blocks
 *
 */

get_header(); ?>

<div class="smartlib-page-blocks">
<?php
    while(have_posts()):the_post();
        the_content();
        endwhile;
?>
</div>
<?php get_footer(); ?>