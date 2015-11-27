<?php
/**
 * Template Name: Portfolio One Column
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




                    <?php
                    $args = array('post_type' => 'smartlib_portfolio', 'posts_per_page' => -1);
                    $portfolio_query = new WP_Query($args);
                    if ($portfolio_query->have_posts()) {

                    while ($portfolio_query->have_posts()):
                    $portfolio_query->the_post();
                    ?>
                        <div class="smartlib-article-box smartlib-article-column-box">
                    <div class="row">
                        <div class="col-md-7 smartlib-no-padding-right">
                            <?php the_post_thumbnail('smartlib-medium-image-portfolio', array('class' => 'img-responsive img-hover', 'alt' => get_the_title()));
                            $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            ?>
                        </div>

                        <div class="col-md-5 smartlib-no-padding-left">
                            <div class="panel-body">
                                <h3>
                                    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                </h3>
                                <?php
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

                                            <p><strong><?php echo $client ?></strong></p>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                <p><?php the_excerpt() ?></p>
                            </div>
                        </div>

                    </div>
                        </div>

                <?php

                endwhile;
                }
                ?>


            </div>

        </div>

        <!-- END #page -->
        <?php endwhile; // end of the loop. ?>


    </section>

<?php get_footer(); ?>