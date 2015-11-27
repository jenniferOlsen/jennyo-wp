<?php


/**
 * Display Slider on Home Page
 * 1 - animate slider
 * 2 - sticky post slider
 * 3 - external slider
 * 4 - ithoust slider
 *
 * @return mixed
 */

function smartlib_slider()
{

    /* get home page slider options */

    $slider_version = (int)get_theme_mod('smartlib_homepage_slider', 2);
    $slider_shortcode = get_theme_mod('smartlib_homepage_slider_shortcode');

    switch ($slider_version) {
        case 1:
            do_action('smartlib_sticky_post_slider');
            break;
        case 2:
            echo do_shortcode('[as-slider]'); //display animate slider
            break;
        case 3:
            if (strlen($slider_shortcode) > 0)
                //echo do_shortcode( $slider_shortcode );
                break;
        default:

    }

}

/**
 * Display author box
 */
function smartlib_display_author_box()
{

    $type = 'blog_single';
    $option = (int)get_theme_mod('smartlib_show_author_' . $type, 1);

    if (is_singular() && get_the_author_meta('description') && is_multi_author() && $option == 1) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries.

        require_once locate_template('/views/snippets/author-info.php');

    endif;

}


/**
 * Display breadcrub trail
 */
function smartlib_breadcrumb()
{
    ?>
    <section class="smartlib-content-section">
        <?php do_action('smartlib_breadcrumb'); ?>
    </section>
<?php
}


function smartlib_post_thumbnail($size = 'thumbnail')
{
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
        return;
    }

    if (is_singular()) :
        ?>

        <span>
		<?php the_post_thumbnail($size); ?>
	</span><!-- .post-thumbnail -->

    <?php else : ?>

        <a href="<?php the_permalink(); ?>" aria-hidden="true">
            <?php
            the_post_thumbnail($size, array('alt' => get_the_title()));
            ?>
        </a>

    <?php endif; // End is_singular()
}

/**
 * Display all thumbnail block
 * @param string $size
 * @param string $type
 */
function smartlib_post_thumbnail_block($size = 'thumbnail', $type = 'blog_loop')
{
    global $post;

    if (strlen($img = get_the_post_thumbnail(get_the_ID(), array(150, 150)))) {
        ?>
        <div class="smartlib-thumbnail-outer">
            <?php smartlib_get_postformat($type); ?>
            <?php smartlib_get_category_line($type); ?>
            <?php smartlib_post_thumbnail($size) ?>
        </div>
    <?php
    }
}

/**
 * Display meta line insingle post, loop
 * @param string $type
 */
function smartlib_meta_post($type = 'blog_loop')
{
    ?>
    <p class="smartlib-meta-line">


        <?php
        if (!strlen($img = get_the_post_thumbnail(get_the_ID(), array(150, 150)))) {

            smartlib_get_category_line($type);
            smartlib_get_postformat($type);
        }
        ?>
        <?php
        do_action('smartlib_date_and_link', $type);
        if (is_single()) {
            do_action('smartlib_author_line', $type);
            do_action('smartlib_comments_count', 'default');

        }


        ?>
    </p>
<?php
}

/**
 * Display home page articles
 */
function smartlib_display_homepage_articles()
{

    $sticky = get_option('sticky_posts');
    $slider_version = get_theme_mod('home_page_slider');
    $news_column = get_theme_mod('home_page_columns');
    $limit = get_theme_mod('home_page_columns'); //skonczyc

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


    /* if sticky post in slider above ommit sticky post*/

    if ($slider_version == 3) {
        $args = array(


            'post___not_in' => $sticky,
            'ignore_sticky_posts' => 1,
            'paged' => $paged

        );
    } else {

        $args = array(
            'paged' => $paged

        );
    }


    $news = new WP_Query($args);

    if ($news->have_posts()) : ?>
        <ul class="smartlib-grid-list smartlib-list-columns-<?php echo $news_column ?>">
            <?php /* start the loop */ ?>
            <?php while ($news->have_posts()) : $news->the_post(); ?>
                <li>  <?php
                    get_template_part('views/content'); ?>

                </li>
            <?php endwhile;
            ?>
        </ul>
        <?php smartlib_list_pagination('nav-below') ?>
    <?php else : ?>
        <article id="post-0" class="post no-results not-found">

            <?php get_template_part('views/content', 'none'); ?>
        </article>
    <?php endif; // end have_posts() check

}

/**
 * Display Layout header - banner or Site description
 *
 * @return mixed
 */

function smartlib_get_header()
{
    ?>
    <header class="frontpage-header" role="banner">

        <?php



        $header_image = get_header_image();

        $banner_header = stripslashes(get_theme_mod('banner_code_header'));
        $front_page_header = get_theme_mod('smartlib_homepage_header', 1);
        $smartlib_fluid_header = get_theme_mod('smartlib_fluid_header_frontpage');


        $slider_section_class = ($smartlib_fluid_header=='2')? 'smartlib-section-fluid':'smartlib-content-section';

        //add default value


        $slider_shortcode = get_theme_mod('smartlib_homepage_slider_shortcode');

        if (is_front_page()) {

            ?>
            <div class="smartlib-content-section">

            <?php

            if (!empty($slider_shortcode)&& $front_page_header == 1) {

                ?>
                <div class="<?php echo $slider_section_class ?> smartlib-main-image-header">
                    <?php echo do_shortcode($slider_shortcode) ?>
                </div>
            <?php
            } elseif (!empty($header_image) && $front_page_header == 1) { ?>
                <div class="<?php echo $slider_section_class ?> smartlib-main-image-header">
                    <img src="<?php echo esc_url($header_image); ?>"
                         class="header-image"
                         width="<?php echo get_custom_header()->width; ?>"
                         height="<?php echo get_custom_header()->height; ?>"
                         alt=""/></div>
            <?php } elseif (!empty($banner_header)) {
                ?>
                <div class="smartlib-header-banner">
                    <?php echo $banner_header ?>
                </div>
            <?php
            } else {

                if ($front_page_header == 1) {
                    ?>

                    <h2 class="site-description" itemprop="description"><?php bloginfo('description'); ?></h2>

                <?php
                }


            }

            ?>

            </div>
                <?php

        }
        ?>

    </header>
<?php
}

/**
 * Display search menu
 */
function smartlib_searchmenu()
{
    ?>
    <ul id="top-switches" class="no-bullet right">
        <li>
            <a href="#toggle-search" class="harmonux-toggle-topbar toggle-button button">
                <span class="fa fa-search"></span>
            </a>
        </li>
        <li class="hide-for-large">
            <a href="#top-navigation" class="harmonux-toggle-topbar toggle-button button">
                <span class="fa fa-align-justify"></span>
            </a>
        </li>
    </ul>
<?php
}

function smartlib_searchform()
{
    ?>
    <form action="<?php echo home_url('/'); ?>" method="get" role="search" id="smartlib-top-search-container">
        <div class="row">
            <div class="col-md-16">
                <input id="search-input" type="text" name="s"
                       placeholder="<?php _e('Search for ...', 'bootframe-core'); ?>" value="">
                <input class="button" id="top-searchsubmit" type="submit"
                       value="<?php _e('Search', 'bootframe-core'); ?>">
            </div>
        </div>

    </form>
<?php
}

function smartlib_toggle_navigation_button()
{
    ?>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header pull-right">
        <button type="button" class=" navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navigation">
            <span class="sr-only sr-only-focusable">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

    </div>
<?php
}

/**
 * Print Search button
 */
function smartlib_toggle_search_button()
{
    ?>
    <button type="button" data-toggle="collapse" data-target="#search-container"
            class="bstarter-toggle-topbar pull-right btn btn-default">
        <span class="sr-only sr-only-focusable"><?php _e('Search', 'smartlib_textdomain');?></span>
        <span class="glyphicon glyphicon-search"></span>
    </button>
<?php
}

function smartlib_display_sidepanel()
{

    /*get all options*/
    $option_1 = get_theme_mod('smartlib_display_sidepanel_blog_single', '1');
    $option_2 = (int)get_theme_mod('smartlib_show_date_blog_single', '1');
    $option_3 = (int)get_theme_mod('smartlib_show_date_default', '1');
    $option_4 = (int)get_theme_mod('smartlib_display_social_buttons_blog_single','1');


    if ($option_1 == 1 && ($option_2 == 1 || $option_4 == 1) && ($option_1 == 1 || $option_3 == 1)) {

        ?>
        <div class="smartlib-side-post-panel">

            <?php
            do_action('smartlib_block_date', 'blog_single');

            do_action('smartlib_social_links_area',$option_4 );
            ?>
        </div>
    <?php
    }
}

/**
 * Print logo theme
 *
 * @return mixed
 */
function smartlib_logo($logo_image = '')
{


    $imageID = get_theme_mod('smartlib_logo', '');

    echo apply_filters('smartlib_before_logo', '<h4 class="smartlib-logo-header" itemprop="headline">');
    ?>
    <a href="<?php echo home_url('/'); ?>"
       title="<?php echo get_bloginfo('name', 'display'); ?>"
       rel="home"
       class="smartlib-site-logo <?php echo (is_numeric($imageID) || strlen($logo_image) > 0) ? 'smartlib-image-logo-link' : ''; ?>">
        <?php
        if (strlen($imageID)> 0) {
            ?>
            <img src="<?php echo $imageID; ?>"
                 alt="<?php echo bloginfo('name'); ?>"/>
        <?php
        } elseif (strlen($logo_image) > 0) {
            ?><img src="<?php echo get_template_directory_uri() . $logo_image ?>"
                   alt="<?php echo bloginfo('name'); ?>" /><?php
        } else {
            bloginfo('name');
        }
        ?></a>
    <?php
    echo apply_filters('smartlib_after_logo', '</h4>');
}

/**
 * Display related posts component
 *
 * @param     $display_post_limit
 * @param int $columns_per_slide
 */

function smartlib_get_related_post_box($display_post_limit = 8, $columns_per_slide = 5)
{
    global $post;

    $category = get_the_category();

    $show_related = (int)get_theme_mod('smartlib_show_related_posts', 1);

    $limit = (int)get_theme_mod('smartlib_limit_related_posts', 8);
    $per_column = (int)get_theme_mod('smartlib_related_posts_limit_per_column');


    $display_post_limit = $limit ? $limit : $display_post_limit;

    $columns_per_slide = $per_column ? $per_column : $columns_per_slide;

    if ($show_related == 1) {
        $query = __SMARTLIB::$layout->get_related_post_box($category[0]->cat_ID, $post->ID, $display_post_limit, $columns_per_slide);

        $limit = $query->found_posts;
        if ($limit != 0) {

            ?>
            <div class="smartlib-related-posts panel">
                <header class="panel-heading">
                    <h3><?php _e('Related posts', 'bootframe-core') ?></h3>
                </header>
                <div class="smartlib-slider-container panel-body">
                    <ul class="smartlib-layout-list slider-list slides ">
                        <?php
                        $i = 1;
                        $j = 1;
                        while ($query->have_posts()) {
                            $query->the_post();

                            $post_format = get_post_format();

                            if ($i == 1) {
                                ?>
                                <li class="row">
                            <?php
                            }
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <?php
                                if ('' != get_the_post_thumbnail()) {
                                    ?>

                                    <a href="<?php the_permalink(); ?>" class="smartlib-thumbnail-outer"
                                       title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'bootframe-core'), the_title_attribute('echo=0'))); ?>"
                                        ><?php do_action('smartlib_get_format_ico', $post_format) ?><?php the_post_thumbnail('smartlib-medium-thumb'); ?></a>

                                <?php
                                }


                                ?>
                                <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                                <?php if (!strlen($img = get_the_post_thumbnail(get_the_ID(), array(150, 150)))) { ?>
                                    <?php do_action('smartlib_display_meta_post', 'default') ?>
                                <?php } ?>
                            </div>

                            <?php
                            if ($i % $columns_per_slide == 0 || $j == $limit) {
                                ?>
                                </li>
                                <?php
                                $i = 1;
                            } else {
                                $i++;
                            }

                            $j++;

                        }// end while


                        ?>
                    </ul>
                </div>


            </div>
        <?php
        }
        wp_reset_query();
        wp_reset_postdata();
    }
}

/**
 * Display related portfolio
 *
 * @param     $display_post_limit
 * @param int $columns_per_slide
 */


function smartlib_get_related_portfolio_box($display_post_limit = 8, $columns_per_slide = 5)
{
    global $post;

    $term = get_the_terms($post->ID, 'portfolio_category');

    $show_related = (int)get_theme_mod('smartlib_show_related_posts', 1);

    $limit = (int)get_theme_mod('smartlib_limit_related_posts', 8);
    $per_column = (int)get_theme_mod('smartlib_related_posts_limit_per_column');


    $display_post_limit = $limit ? $limit : $display_post_limit;

    $columns_per_slide = $per_column ? $per_column : $columns_per_slide;

    if ($show_related == 1) {
        $query = __SMARTLIB::$layout->get_related_portfolio_box($term[0]->term_id, $post->ID, $display_post_limit);

        $limit = $query->found_posts;
        if ($limit != 0) {

            ?>
            <div class="smartlib-related-posts panel">
                <header class="panel-heading">
                    <h3><?php _e('Related works', 'bootframe-core') ?></h3>
                </header>
                <div class="smartlib-slider-container panel-body">
                    <ul class="smartlib-layout-list slider-list slides ">
                        <?php
                        $i = 1;
                        $j = 1;
                        while ($query->have_posts()) {
                            $query->the_post();


                            if ($i == 1) {
                                ?>
                                <li class="row">
                            <?php
                            }
                            ?>
                            <div class="col-md-3">

                                <div class="smartlib-thumbnail-outer smartlib-thumbnail-hover-area ">

                                    <?php
                                    if ('' != get_the_post_thumbnail()) {
                                        ?>
                                        <?php the_post_thumbnail('smartlib-large-thumb'); ?>
                                    <?php
                                    }

                                    $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                    ?>

                                    <div class="smartlib-thumbnail-caption smartlib-wide-caption">
                                        <div class="smartlib-table-container">
                                            <div class="smartlib-table-cell smartlib-vertical-middle text-center">
                                                <a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary"><i
                                                        class="fa fa-link"></i></a> <a href="<?php echo $src[0] ?>"
                                                                                       class="btn btn-primary "
                                                                                       rel="smartlib-resize-photo[portfolio_telated]"><i
                                                        class="fa fa-expand"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>

                                    <p><?php the_excerpt() ?></p>
                                </div>
                            </div>

                            <?php
                            if ($i % $columns_per_slide == 0 || $j == $limit) {
                                ?>
                                </li>
                                <?php
                                $i = 1;
                            } else {
                                $i++;
                            }

                            $j++;

                        }// end while


                        ?>
                    </ul>
                </div>


            </div>
        <?php
        }
        wp_reset_query();
        wp_reset_postdata();
    }
}

/**
 * Display pagination on the loop page
 *
 * @param $html_id
 *
 * @return mixed
 */
function smartlib_list_pagination($html_id)
{
    global $wp_query;

    $pagination_option = (int)get_theme_mod('smartlib_pagination_posts', 1);
    $html_id = esc_attr($html_id);
    if ($pagination_option > 0) {
        if ($wp_query->max_num_pages > 1) {
            ?>
            <nav id="<?php echo $html_id; ?>" class="smartlib-pagination-area" role="navigation">
                <h3 class="sr-only"><?php _e('Post navigation', 'bootframe-core'); ?></h3>
                <?php

                if ($pagination_option == '1') {

                    do_action('smartlib_prev_next_links');
                } else {
                    //get custom smartlib pagination
                    do_action('smartlib_pagination_number_links');
                }
                ?>
            </nav>
        <?php

        }
    }
}

function smartlib_box_footer()
{
    ?>
    <p class="smartlib-meta-line smartlib-footer-meta-line">
        <?php do_action('smartlib_author_line', 'blog_loop') ?>
        <span class="pull-right"><?php do_action('smartlib_comments_count', 'default') ?></span>
    </p>
<?php
}

/*template tags actions decorators - get prefix*/

function smartlib_get_date_and_link($type = '')
{
    do_action('smartlib_date_and_link', $type);
}

function smartlib_get_postformat($type = '')
{
    do_action('smartlib_display_postformat', $type);
}

function smartlib_get_category_line($type = '')
{
    do_action('smartlib_category_line', $type);
}

function smartlib_get_author_line($type = '')
{
    do_action('smartlib_author_line', $type);
}


function smartlib_page_image_header()
{
    global $post;

    $header_bg = get_post_meta($post->ID, 'smartlib_page_header_background', true);

    return $header_bg;
}

function smartlib_get_section_info_text($area = 'header')
{
    $info = get_theme_mod('smartlib_text_' . $area, '');

    if (strlen($info) > 0) {
        echo $info;
    }
}

/*
 * Display page subtitle
 */

function smartlib_get_subtitle()
{
    global $post;

    $subtitle = get_post_meta($post->ID, 'smartlib_page_subtitle', true);

    return $subtitle;
}

/*
 * Check if page has traditional title
 */

function smartlib_page_has_title()
{
    $header_bg = smartlib_page_image_header();

    return !(bool)strlen($header_bg) > 0;
}

function smartlib_if_is_one_page(){
    global $post;

    $template = '';

    if(isset($post->ID)){

        $template = get_post_meta( $post->ID, '_wp_page_template', true );

    }



    if($template =='page-one-page.php'){
        return true;
    }
    else{
        return false;
    }

}

/**
 * Display home page name
 */
function smartlib_get_onepage_home(){

    echo get_theme_mod('smartlib_breadcrumb_homepage_name', __('Home', 'bootframe-core'));

}

/**
 * Return loop template variant insist on sidebar settings
 * @return string
 */

function smartlib_get_loop_variant(){

    $sidebar_option_blog_loop = get_theme_mod('smartlib_layout_blog_loop', 1);

    $cat = get_query_var('cat');

    $cat_extra_data = get_option( 'category_' . $cat );

    $category_variant = isset($cat_extra_data['smartlib_layout_category'])? (int)$cat_extra_data['smartlib_layout_category']:0;



    if($sidebar_option_blog_loop==0){
        return 'no-sidebar';
    }elseif($category_variant==1){
        return 'no-sidebar';
    }else{
        return 'sidebar';
    }


}


/**
 * Template for comments and pingbacks.
 */
function smartlib_comment_template( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            // Display trackbacks differently than normal comments.
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <p><?php _e( 'Pingback:', 'bootframe-core' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'bootframe-core' ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
            break;
        default :
            // Proceed with normal comments.
            global $post;
            ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <header class="comment-meta comment-author vcard">
                    <?php
                    $user_photo = get_user_meta( $comment->user_id, 'smartlib_profile_image', true );
                    if ( ! empty( $user_photo ) ) {
                        ?>
                        <img src="<?php echo $user_photo?>" alt="User" width="44" height="44" />
                    <?php

                    }
                    else
                        echo get_avatar( $comment, 44 );
                    printf( '<cite class="smartlib-comment-author comment-author fn">%1$s %2$s</cite>',
                        get_comment_author_link(),
                        // If current post author is also comment author, make it known visually.
                        ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'bootframe-core' ) . '</span>' : ''
                    );
                    printf( '<span class="smartlib-comment-metadata pull-right"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span>',
                        esc_url( get_comment_link( $comment->comment_ID ) ),
                        get_comment_time( 'c' ),
                        /* translators: 1: date, 2: time */
                        sprintf( __( '%1$s at %2$s', 'bootframe-core' ), get_comment_date(), get_comment_time() )
                    );
                    ?>
                    <?php edit_comment_link( __( 'Edit', 'bootframe-core' ), '<p class="smartlib-edit-content-link">', '</p>' ); ?>
                </header>
                <!-- .comment-meta -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bootframe-core' ); ?></p>
                <?php endif; ?>

                <section class="comment-content comment">
                    <?php comment_text(); ?>
                </section>
                <!-- .comment-content -->

                <div class="reply smartlib-comment-replay">
                    <?php
                    echo preg_replace( '/comment-reply-link/', 'comment-reply-link ' . 'btn btn-default btn-small pull-right',

                        get_comment_reply_link(array_merge( $args, array(
                            'reply_text' => __( 'Reply', 'bootframe-core' ),
                            'depth' => $depth,
                            'max_depth' => $args['max_depth']))), 1 );

                    //comment_reply_link( array_merge( $args, array( , 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
                <!-- .reply -->
            </article><!-- #comment-## -->
            <?php
            break;
    endswitch; // end comment_type check
}

/**
 * Display Aythor social profiles
 */

function smartlib_ext_user_profile_fields(){
    /*
     * Social Icons
     */
    $profile_links = array();

    $profile_links['twitter'] =  get_the_author_meta('twitter');
    $profile_links['facebook'] = get_the_author_meta('facebook');
    $profile_links['gplus'] = get_the_author_meta('gplus');
    $profile_links['pinterest'] = get_the_author_meta('pinterest');
    $profile_links['linkedin'] = get_the_author_meta('linkedin');
    $profile_links['youtube'] = get_the_author_meta('youtube');

    if(count($profile_links)>0){
        ?>
        <ul class="smartlib-author-profile-links list-inline">
            <?php
            foreach($profile_links as $key =>$row){
               if(strlen($row)>0){
                ?>
                <li><a href="<?php echo $row ?>" class="smartlib-icon smartlib-small-square-icon smartlib-<?php echo $key ?>-ico"><i class="<?php echo apply_filters('smartlib_get_awesome_ico', 'fa fa-share', $key); ?>"></i></a></li>
            <?php
               }
            }
            ?>
        </ul>

    <?php

    }

}
