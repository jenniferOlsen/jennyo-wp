<?php
/**
 * The template for displaying all pages.
 *
 */

get_header();

while (have_posts()) : the_post();

    do_action('smartlib_header_page');

?>

<section class="smartlib-content-section container">


 <div id="page" class="<?php echo bstarter__f('smartlib_content_layout_class', 'col-sm-16 col-md-12', 'page' ) ?>">

    <?php

    $header_bg = smartlib_page_image_header();

    if(strlen($header_bg)>0){
        get_template_part('views/content', 'page-image-header');
    }else{
        get_template_part('views/content', 'page');
    }


    ?>
    <?php comments_template('', true); ?>



        </div>
<!--end #page-->
<?php do_action('smartlib_get_layout_sidebar', 'page');//display homepage sidebar ?>

</section>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>