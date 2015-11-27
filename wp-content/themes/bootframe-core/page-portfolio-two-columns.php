<?php
/**
 * Template Name: Portfolio Two Columns
 *
 */

get_header();
?>

    <section class="smartlib-content-section smartlib-portfolio-content container">
        <?php do_action('smartlib_breadcrumb'); ?>
            <?php while (have_posts()) :
            the_post(); ?>
            <div id="page" class="smartlib-no-sidebar">

                <header class="smartlib-page-header">
                    <h1 class="page-header"><?php the_title(); ?>
                        <small>Subheading</small>
                    </h1>
                </header>


                <div class="row">
                    <ul class="smartlib-layout-list smartlib-layout-isotope-list">

                        <?php
                        $args = array('post_type' => 'smartlib_portfolio', 'posts_per_page' => -1);
                        $portfolio_query = new WP_Query($args);
                        if ($portfolio_query->have_posts()) {

                            while ($portfolio_query->have_posts()): $portfolio_query->the_post();
                                ?>
                                <li class="col-md-6 img-portfolio shuffle-item filtered"
                                    data-groups='<?php echo apply_filters('smartlib_portfolio_filter_string', '["all"]') ?>'>
                                    <div class="panel">
                                        <div class="smartlib-thumbnail-outer smartlib-thumbnail-hover-area ">
                                            <?php the_post_thumbnail('smartlib-medium-image-portfolio', array('class' => 'img-responsive img-hover', 'alt' => get_the_title()));
                                            $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                            ?>


                                            <div class="smartlib-thumbnail-caption smartlib-wide-caption">
                                                <div class="smartlib-table-container">
                                                    <div
                                                        class="smartlib-table-cell smartlib-vertical-middle text-center">
                                                        <a href="<?php the_permalink() ?>" class="btn btn-primary"><i
                                                                class="fa fa-link"></i></a> <a
                                                            href="<?php echo $src[0] ?>"
                                                            class="btn btn-primary "
                                                            rel="smartlib-resize-photo[portfolio1]"><i
                                                                class="fa fa-expand"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <h3>
                                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            </h3>

                                            <p><?php the_excerpt() ?></p>
                                        </div>
                                    </div>
                                </li>

                            <?php

                            endwhile;
                        }
                        ?>

                    </ul>
                </div>

            </div>

        <!-- END #page -->
        <?php endwhile; // end of the loop. ?>


    </section>

<?php get_footer(); ?>