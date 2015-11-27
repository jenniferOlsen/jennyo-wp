<?php

global $post;

$header_bg = smartlib_page_image_header();
$dark_section = get_post_meta($post->ID, 'smartlib_header_dark_section', true);
$paralax_section = get_post_meta($post->ID, 'smartlib_header_paralax_effect', true);
$section_overlay_color = get_post_meta($post->ID, 'smartlib_page_header_color_background', true);

if(strlen($header_bg)>0){

    $image = wp_get_attachment_image_src($header_bg, 'full');
    $image
    ?>
    <section class="<?php echo apply_filters('smartlib_page_header_class', 'smartlib-full-width-section smartlib-page-image-header',  $dark_section, $paralax_section, $section_overlay_color); ?>" style="background: url('<?php echo $image[0]; ?>')" <?php echo strlen($section_overlay_color)>0? 'data-type="background" data-overlay-color="'.$section_overlay_color.'"' :''; ?>>

        <div class="container smartlib-no-padding">

            <div class="smartlib-table-container">

                <div class="smartlib-table-cell">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="page-header smartlib-page-title"><?php the_title() ?>
                                <small><?php echo smartlib_get_subtitle() ?></small>
                            </h1>
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="smartlib-breadcrumb">
                                <?php do_action('smartlib_breadcrumb'); ?>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </section>
    <?php
}else{
?>
<section class="smartlib-content-section container">
    <?php do_action('smartlib_breadcrumb'); ?>

</section>
<?php
}
?>
