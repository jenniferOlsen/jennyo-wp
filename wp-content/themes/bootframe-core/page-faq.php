<?php
/**
 * Template Name: FAQ
 *
 */

get_header();

while (have_posts()) : the_post();

do_action('smartlib_header_page');
?>

    <section class="smartlib-content-section container">

                <div id="page" class="smartlib-no-sidebar">
                    <article class="smartlib-page-container">
                    <header class="smartlib-page-header">
                        <?php if(smartlib_page_has_title()) { ?>
                            <h1 class="page-header">
                                <?php the_title(); ?>
                                <small><?php echo smartlib_get_subtitle() ?></small>
                            </h1>
                        <?php
                        }
                         ?>
                    </header>
                    <?php the_content(); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="smartlib-accordion">

                                <?php
                                $args = array('post_type' => 'smartlib_faq', 'posts_per_page' => -1);
                                $faq_query = new WP_Query($args);
                                if ($faq_query->have_posts()) {

                                    while ($faq_query->have_posts()): $faq_query->the_post();
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#smartlib-accordion"
                                                       href="#collapse<?php echo get_the_ID(); ?>"><?php the_title() ?></a>
                                                </h4>
                                            </div>
                                            <div id="collapse<?php echo get_the_ID(); ?>"
                                                 class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p><?php the_excerpt() ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    <?php

                                    endwhile;
                                }
                                ?>

                            </div>
                        </div>

                    </div>
                        </article>
                </div>
                <!-- END #page -->

    </section>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>