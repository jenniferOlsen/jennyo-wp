<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

?>
    <section class="smartlib-content-section smartlib-portfolio-content container">
        <?php while (have_posts()) : the_post(); ?>
            <div id="page" role="main" class="smartlib-no-sidebar">
                <?php do_action('smartlib_breadcrumb'); ?>
                <header class="smartlib-page-header">
                    <div class="row">
                    <div class="col-lg-10"><h1 class="entry-title"><?php the_title(); ?></h1></div>
                    <div class="col-lg-2">
                        <ul class="smartlib-prev-next-nav">
                            <li><?php next_post_link('%link',''); ?></li>
                            <li><?php previous_post_link('%link',''); ?></li>
                        </ul>
                    </div>
                    </div>
                </header>

                <article class="smartlib-page-container">
                    <div class="row">

                        <div class="col-md-8">
                            <!--portfolio slider-->
                            <div class="smartlib-slider-container">
                                <?php
                                $img_array = get_post_meta($post->ID, 'smartlib_item_image', false);
                                ?>
                                <?php
                                if (count($img_array) > 0) {

                                    ?>
                                    <!-- Wrapper for slides -->
                                    <ul class="slides">

                                        <?php


                                        foreach ($img_array as $row) {
                                            $full_img = wp_get_attachment_image_src($row, 'full');
                                            $thumb_img = wp_get_attachment_image_src($row, 'smartlib-medium-image-portfolio');
                                            ?>
                                            <li>
                                                <div class="smartlib-thumbnail-hover-area">
                                                    <div class="smartlib-hover-options"><a
                                                            class="btn btn-primary btn-xs"
                                                            href="<?php echo $full_img[0] ?>"
                                                            rel="smartlib-resize-photo[portfolio1]"><i
                                                                class="fa fa-expand"></i></a></div>
                                                    <img class="img-responsive"
                                                         src="<?php echo $thumb_img[0] ?>" alt="<?php echo get_post_meta($row, '_wp_attachment_image_alt', true);?>"
                                                         draggable="false"></div>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                <?php
                                }
                                ?>

                            </div>
                            <!--end portfolio slider-->
                        </div>

                        <div class="col-md-4">
                            <div class="smartlib-content-container">
                                <h3><?php _e('Project Description', 'bootframe-core') ?></h3>
                                <?php the_content();

                                $terms = wp_get_post_terms($post->ID, 'portfolio_skills');
                                ?>
                                <ul class="smartlib-portfolio-details smartlib-layout-list">
                                    <?php
                                    if (count($terms) > 0) {
                                        ?>
                                        <li>
                                            <h4><?php _e('Skills:', 'bootframe-core') ?></h4>

                                            <ul class="list-unstyled list-inline">
                                                <?php
                                                foreach ($terms as $term) {
                                                    ?>
                                                    <li><i class="fa fa-check-circle"></i> <?php echo $term->name ?>
                                                    </li>
                                                <?php
                                                }
                                                ?>


                                            </ul>
                                        </li>
                                    <?php
                                    }

                                    $client = get_post_meta($post->ID, 'smartlib_client_name', true);
                                    if (strlen($client) > 0) {
                                        ?>
                                        <li>
                                            <h4><?php _e('Client: ', 'bootframe-core') ?></h4>

                                            <p><?php echo $client ?></p>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </article>



                <?php smartlib_get_related_portfolio_box(8, 4); ?>

                <?php //smartlib_get_related_post_box(8, 4); ?>


            </div><!-- END #page -->
        <?php endwhile; // end of the loop. ?>


    </section>
<?php get_footer(); ?>