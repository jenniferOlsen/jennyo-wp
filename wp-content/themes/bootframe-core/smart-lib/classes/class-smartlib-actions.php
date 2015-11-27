<?php


class Smartlib_Actions
{

    static $instance;
    public $default_config;

    public function __construct($conObj)
    {
        self::$instance =& $this;

        $this->default_config = $conObj;

        //add actions

        add_action('smartlib_breadcrumb', array($this, 'smartlib_breadcrumb'), 10);
        add_action('smartlib_footer_text', array($this, 'smartlib_footer_text'), 10);
        add_action('smartlib_prev_next_post_navigation', array($this, 'smartlib_prev_next_post_navigation'), 10);
        add_action('smartlib_custom_single_page_pagination', array($this, 'smartlib_custom_single_page_pagination'), 10, 1);
        add_action('smartlib_comment_list', array($this, 'smartlib_comment_list'), 10);
        add_action('smartlib_ie_support', array($this, 'smartlib_ie_support'), 10);
        add_action('smartlib_excerpt_max_charlength', array($this, 'smartlib_excerpt_max_charlength'), 10, 1);
        add_action('smartlib_display_postformat', array($this, 'smartlib_display_postformat'), 10, 1);
        add_action('smartlib_display_meta_post', array($this, 'smartlib_display_meta_post'), 10, 1);
        add_action('smartlib_mobile_menu', array($this, 'smartlib_mobile_menu'), 10, 1);
        add_action('smartlib_date_and_link', array($this, 'smartlib_date_and_link'), 10, 1);
        add_action('smartlib_comment_link_header', array($this, 'smartlib_comment_link_header'), 10);
        add_action('smartlib_comments_count', array($this, 'smartlib_comments_count'), 10);

        add_action('smartlib_category_line', array($this, 'smartlib_category_line'), 10, 1);
        add_action('smartlib_get_layout_sidebar', array($this, 'smartlib_get_layout_sidebar'), 10, 1);
        add_action('smartlib_get_related_post_box', array($this, 'smartlib_get_related_post_box'), 10, 2);
        add_action('smartlib_dynamic_sidebar_grid', array($this, 'smartlib_dynamic_sidebar_grid'), 10, 1);
        add_action('smartlib_password_form', array($this, 'smartlib_password_form'), 10);
        add_action('smartlib_sticky_post_slider', array($this, 'smartlib_sticky_post_slider'), 10);
        add_action('smartlib_social_links_area', array($this, 'smartlib_social_links_area'), 10, 1);
        add_action('smartlib_footer_sidebar', array($this, 'smartlib_footer_sidebar'), 10, 1);

        add_action('smartlib_author_line', array($this, 'smartlib_author_line'), 10, 1);
        add_action('smartlib_entry_tags', array($this, 'smartlib_entry_tags'), 10, 1);

        add_action('smartlib_block_date', array($this, 'smartlib_block_date'), 10);

        add_action('smartlib_social_links', array($this, 'smartlib_social_links'), 10, 1);


        /*pagination hooks*/
        add_action('smartlib_prev_next_links', array($this, 'smartlib_prev_next_links'), 10);
        add_action('smartlib_pagination_number_links', array($this, 'smartlib_pagination_number_links'), 10);

        add_action('smartlib_before_content', array($this, 'smartlib_preloader'), 10);

        add_action('smartlib_header_page', array($this, 'smartlib_single_page_header'), 10);

        /*navigation actions*/

        add_action('smartlib_top_bar', array($this, 'smartlib_display_top_bar'), 10);
        add_action('smartlib_top_search', array($this, 'smartlib_top_search'), 10);

        /*footer actions*/

        add_action('smartlib_after_content', array($this, 'smartlib_go_top_button'), 10);


    }


    /**
     * Print breadcrumb trail


     */
    function smartlib_breadcrumb()
    {

        global $post;

        //Get bredcrumb separator option
        $sep = '<span class="smartlib-separator">'.get_theme_mod('smartlib_breadcrumb_separator_page', '/'). '</span>';

        echo '<ol class="breadcrumb">';
        if (!is_front_page()) {
            echo '<li><a href="';
            echo home_url();
            echo '">';
            bloginfo('name');
            echo '</a>' . $sep . '</li>';

            if (is_category() || is_single()) {
                $args = array('fields' => 'all');
                $categories = wp_get_post_categories( $post->ID, $args );

                if(count($categories)){

                    foreach($categories  as $category){
                        ?>
                        <li><a href="<?php echo get_category_link($category->term_id) ?>"><?php echo $category->name ?></a><?php echo $sep ?></li>
                        <?php
                    }

                }


            } elseif (is_archive() || is_single()) {

                ?>
                <li><?php
                if (is_day()) {
                    printf(__('%s', 'bootframe-core'), get_the_date());
                } elseif (is_month()) {
                    printf(__('%s', 'bootframe-core'), get_the_date(_x('F Y', 'monthly archives date format', 'bootframe-core')));
                } elseif (is_year()) {
                    printf(__('%s', 'bootframe-core'), get_the_date(_x('Y', 'yearly archives date format', 'bootframe-core')));
                } else {
                    _e('Blog Archives', 'bootframe-core');
                }

                ?></li>
                <?php

            }

            if (is_page()) {
                echo '<li>' . get_the_title() . '</li>';
            }
        }
        echo '</ol>';
    }

    /**
     * Display footer text
     */
    public function smartlib_footer_text()
    {
        return get_theme_mod('footer_text');
    }


    /**
     * Display meta line under post title - use for widgets, boxs
     *
     * @param string $type author|category|date
     */
    function smartlib_display_meta_post($type = 'blog_loop')
    {
        ?>
        <p class="smartlib-meta-line">
            <?php

            do_action('smartlib_date_and_link', $type);
            do_action('smartlib_display_postformat', $type);
            do_action('smartlib_comment_link_header');
            do_action('smartlib_category_line', $type);
            ?>
        </p>
    <?php

    }

    /**
     * Display Date Line with link
     *
     * @param string $type
     *
     * @return void
     */
    function smartlib_date_and_link($type = '')
    {


        $type = $this->get_context_type($type);


        $option = (int)$this->smartlib_get_option('smartlib_show_date_', $type, '1');

        if ($option == 1) {

            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if (get_the_time('U') !== get_the_modified_time('U')) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
            }

            $time_string = sprintf($time_string,
                esc_attr(get_the_date('c')),
                esc_html(get_the_date()),
                esc_attr(get_the_modified_date('c')),
                esc_html(get_the_modified_date())
            );
            $class = apply_filters('smartlib_conditional_class', '', 'smartlib_display_sidepanel_blog_single', '0');
            printf('<span class="smartlib-data-line%1$s"><i class="fa fa-calendar"></i> <a href="%2$s" rel="bookmark">%3$s</a></span>',
                $class,
                esc_url(get_permalink()),
                $time_string
            );
        }

    }

    /**
     * Get context type based on conditional tags and passed type
     *
     * @param $passed_type
     *
     * @return string
     */
    public function get_context_type($passed_type)
    {
        global $post;

        $type = '';

        if ($passed_type == '') {

            if (is_page()) {
                $type = 'page';
            }

            if (is_single()) {
                $type = 'blog_single';
            }
            if (is_archive()) {
                $type = 'blog_loop';
            }

            if ($type == '') {
                $type = 'default';
            }
            return $type;

        } else {
            return $passed_type;
        }


    }

    /**
     * Get theme option based on prefix and context - if not exists get default
     * @param $prefix
     * @param $type
     * @param int $default
     * @return int
     */
    private function smartlib_get_option($prefix, $type, $default = 1)
    {

        $option = get_theme_mod($prefix . $type);

        if ($option == '') {
            $option = get_theme_mod($prefix . 'default', $default);
        }
        return (int)$option;
    }

    /**
     * Get large date block on single post page
     * @param string $type
     */
    function smartlib_block_date($type = '')
    {


        $type = $this->get_context_type($type);


        $option = (int)$this->smartlib_get_option('smartlib_show_date_', $type);


        if ($option == 1) {
            ?>

            <?php
            $time_string = '<span class="smartlib-date-label"><time datetime="%1$s"><strong>%2$s</strong>%3$s</time></span>';


            $time_string = sprintf($time_string,
                esc_attr(get_the_date('c')),
                esc_html(get_the_date('d')),
                esc_html(get_the_date('M Y'))

            );

            echo $time_string;
        }

    }

    /**
     * Display comment link
     *
     * @param string $type
     */
    public function smartlib_comment_link_header($type = '')
    {

        $type = $this->get_context_type($type);

        $option = (int)get_theme_mod('smartlib_show_replylink_' . $type, 1);
        if ($option == 1) {
            if (comments_open() && is_single()) {
                ?>
                <span
                    class="meta-label comment-label"><?php comments_popup_link(__('Comment', 'bootframe-core') . apply_filters('smartlib_get_awesome_ico', 'comments') . '</span>', __('1 Reply', 'bootframe-core'), __('% Replies', 'bootframe-core')); ?></span>
            <?php

            }
        }
    }

    public function smartlib_comments_count($type = 'default')
    {


        $option = (int)get_theme_mod('smartlib_show_comments_count_' . $type, 1);

        if ($option == 1) {
            ?>
            <a href="<?php echo get_comments_link(); ?>"><i class="fa fa-comments" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Comments"></i> <?php echo get_comments_number() ?>
            </a>
        <?php
        }

    }


    /*
                * Display smartlib paginate links
                */

    /**
     * @param string $type - single or loop
     */
    public function smartlib_category_line($type = '')
    {

        $type = $this->get_context_type($type);

        $option = (int)get_theme_mod('smartlib_show_category_' . $type, '1');

        if ($option == 1) {

            $category_list = get_the_category_list(__(' / ', 'bootframe-core'));

            if (strlen($category_list > 0)) {
                ?>
                <span class="label label-default smartlib-category-line">
	                <?php echo get_the_category_list(__(' / ', 'bootframe-core')); ?>
                </span>
            <?php
            }

        }
    }

    public function smartlib_display_postformat($type = '', $show_text = false)
    {
        global $post;


        $type = $this->get_context_type($type);
        $option = (int)get_theme_mod('smartlib_show_postformat_' . $type, 1);

        $post_format = get_post_format($post->ID);

        $promoted_formats = $this->default_config->get_promoted_formats();
        if ($option == 1) {
            if (in_array($post_format, $promoted_formats)) {
                ?>
                <span
                    class="smartlib-format-ico <?php echo apply_filters('smartlib_get_awesome_ico', 'fa-li fa fa-check-square', $post_format) ?>"><?php echo ($show_text) ? $post_format : ''; ?></span>
            <?php
            }
        }
    }

    public function smartlib_pagination_number_links()
    {
        global $wp_query;

        $big = 999999999; // This needs to be an unlikely integer
        $current = max(1, get_query_var('paged'));
        // For more options and info view the docs for paginate_links()
        // http://codex.wordpress.org/public function_Reference/paginate_links
        $paginate_links = paginate_links(array(
            'base' => str_replace($big, '%#%', get_pagenum_link($big)),
            'current' => $current,
            'total' => $wp_query->max_num_pages,
            'mid_size' => 5,
            'type' => 'array'
        ));

        // Display the pagination if more than one page is found
        if ($paginate_links) {

            echo '<ul class="pagination smartlib-pagination">';
            foreach ($paginate_links as $row) {

                ?>
                <li><?php echo $row ?></li>
            <?php

            }
            echo '</ul><!--// end .pagination -->';
        }
    }

    public function smartlib_prev_next_links()
    {
        ?>
        <div class="smartlib-next-prev">
            <?php next_posts_link(__('&larr; Older posts', 'bootframe-core')); ?>
            <?php previous_posts_link(__('Newer posts &rarr;', 'bootframe-core')); ?>
        </div>
    <?php

    }

    /**
     * Displays navigation to next/previous post on single  page.
     */

    public function smartlib_prev_next_post_navigation()
    {
        $option = get_theme_mod('blog_show_prev_next');

        if ($option == '1') {
            require_once locate_template('/views/snippets/prev-next-nav.php');

        }
    }

    /**
     * Modyfication wp_link_pages() - <!--nextpage--> pagination
     *
     * @return mixed
     */
    public function smartlib_custom_single_page_pagination($args = '')
    {

        $defaults = array(
            'before' => '<div id="post-pagination" class="smartlib-pagination-area">' . __('Pages:', 'bootframe-core'),
            'after' => '</div>',
            'text_before' => '',
            'text_after' => '',
            'next_or_number' => 'number',
            'nextpagelink' => __('Next page', 'bootframe-core'),
            'previouspagelink' => __('Previous page', 'bootframe-core'),
            'pagelink' => '%',
            'echo' => 1
        );

        $r = wp_parse_args($args, $defaults);
        $r = apply_filters('wp_link_pages_args', $r);
        extract($r, EXTR_SKIP);

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ($multipage) {
            if ('number' == $next_or_number) {
                $output .= $before;
                for ($i = 1; $i < ($numpages + 1); $i = $i + 1) {
                    $j = str_replace('%', $i, $pagelink);
                    $output .= ' ';
                    if ($i != $page || ((!$more) && ($page == 1)))
                        $output .= _wp_link_page($i);
                    else
                        $output .= '<span class="current-post-page">';

                    $output .= $text_before . $j . $text_after;
                    if ($i != $page || ((!$more) && ($page == 1)))
                        $output .= '</a>';
                    else
                        $output .= '</span>';
                }
                $output .= $after;
            } else {
                if ($more) {
                    $output .= $before;
                    $i = $page - 1;
                    if ($i && $more) {
                        $output .= _wp_link_page($i);
                        $output .= $text_before . $previouspagelink . $text_after . '</a>';
                    }
                    $i = $page + 1;
                    if ($i <= $numpages && $more) {
                        $output .= _wp_link_page($i);
                        $output .= $text_before . $nextpagelink . $text_after . '</a>';
                    }
                    $output .= $after;
                }
            }
        }else{

            wp_link_pages( $defaults );
        }
        if (is_single() || is_page()) {
            if ($echo)
                echo $output;

            return $output;
        } else {
            return '';
        }
    }

    /*
                * Return excerpt with limit
                */

    /**
     * Display comment components
     *
     * @param $comment
     * @param $args
     * @param $depth
     *
     * @return mixed
     */
    public function smartlib_comment_component($comment, $args, $depth)
    {
        // Proceed with normal comments.
        global $post;
        $GLOBALS['comment'] = $comment;


        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments.
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p><?php _e('Pingback:', 'bootframe-core'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'bootframe-core'), '<span class="edit-link">', '</span>'); ?></p>
                </li>
                <?php
                break;
            default :

                //	var_dump($comment);
                require_once(locate_template('smart-lib/snippets/comment-component.php'));
                break;
        endswitch; // end comment_type check
    }

    public function smartlib_ie_support()
    {

        ?><!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font/css/font-awesome-ie7.min.css">
	<![endif]-->
        <!--[if IE 7]>
        <style>
            * {
                *behavior: url(< ? php echo get_template_directory_uri();
                ? > / js / boxsize-fix . htc );
            }
        </style>
        <![endif]-->
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
    <?php

    }

    public function smartlib_excerpt_max_charlength($charlength)
    {
        $excerpt = get_the_excerpt();
        $charlength++;

        if (mb_strlen($excerpt) > $charlength) {
            $subex = mb_substr($excerpt, 0, $charlength - 5);
            $exwords = explode(' ', $subex);
            $excut = -(mb_strlen($exwords[count($exwords) - 1]));
            if ($excut < 0) {
                echo mb_substr($subex, 0, $excut);
            } else {
                echo $subex;
            }
            echo '...';
        } else {
            echo $excerpt;
        }
    }


    /*
                             *  Add dynamic select menus  for mobile device navigation * *
                             *
                             * @since BootFrame 1.0
                             * @link: http://kopepasah.com/tutorials/creating-dynamic-select-menus-in-wordpress-for-mobile-device-navigation/
                             *
                             * @param array $args
                             *
                        */

    /**
     * Return custom_code_header
     *
     * @return string
     */
    public function smartlib_option_custom_code_header()
    {

        get_theme_mod('custom_code_header');

    }

    /**
     * Display lt ie7 info
     */

    public function smartlib_lt_ie7_info()
    {
        ?>
        <!--[if lt IE 7]>
        <p class=chromeframe>Your browser is <em>ancient!</em> Upgrade to a
            different browser.
        </p>
        <![endif]-->
    <?php

    }

    public function  smartlib_mobile_menu($args = array())
    {


        $defaults = array(
            'theme_location' => '',
            'menu_class' => 'mobile-menu',
        );

        $args = wp_parse_args($args, $defaults);

        $menu_item = $this->wp_nav_menu_select();

        if ($menu_item) {
            ?>

            <select id="menu-<?php echo $args['theme_location'] ?>" class="<?php echo $args['menu_class'] ?>">
                <option value=""><?php _e('- Select -', 'bootframe-core'); ?></option>
                <?php foreach ($menu_item as $id => $data) : ?>
                    <?php if ($data['parent'] == true) : ?>
                        <optgroup label="<?php echo $data['item']->title ?>">
                            <option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
                            <?php foreach ($data['children'] as $id => $child) : ?>
                                <option value="<?php echo $child->url ?>"><?php echo $child->title ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php else : ?>
                        <option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        <?php

        } else {
            ?>
            <select class="menu-not-found">
                <option value=""><?php _e('Menu Not Found', 'bootframe-core'); ?></option>
            </select>
        <?php

        }

    }

    public function wp_nav_menu_select($args = array())
    {

        $menu = array();


        $menu_locations = get_nav_menu_locations();

        $layout_variant = get_theme_mod('page_layout');

        //*check layout variant
        if (!in_array($layout_variant, $this->mobile_menu_exclude)) {

            if (isset($menu_locations[$args['theme_location']])) {
                $menu = wp_get_nav_menu_object($menu_locations[$args['theme_location']]);
            }

            if (count($menu) > 0 && isset($menu->term_id)) {


                $menu_items = wp_get_nav_menu_items($menu->term_id);

                $children = array();
                $parents = array();

                foreach ($menu_items as $id => $data) {
                    if (empty($data->menu_item_parent)) {
                        $top_level[$data->ID] = $data;
                    } else {
                        $children[$data->menu_item_parent][$data->ID] = $data;
                    }
                }

                foreach ($top_level as $id => $data) {
                    foreach ($children as $parent => $items) {
                        if ($id == $parent) {
                            $menu_item[$id] = array(
                                'parent' => true,
                                'item' => $data,
                                'children' => $items,
                            );
                            $parents[] = $parent;
                        }
                    }
                }

                foreach ($top_level as $id => $data) {
                    if (!in_array($id, $parents)) {
                        $menu_item[$id] = array(
                            'parent' => false,
                            'item' => $data,
                        );
                    }
                }

                uksort($menu_item, array(__CLASS__, 'wp_nav_menu_select_sort'));
                return $menu_item;


            } else {

                return false;
            }
        }
    }


    /*
                * Print author line
                */

    /**
     * Get alyout sidebar- based on main layout setting - smartlib_get_sidebar decorator
     *
     * @param string $type
     */
    public function smartlib_get_layout_sidebar($type = 'default')
    {
        global $post;


        //get columns layout class
        $layout_class_array = $this->default_config->layout_class_array;

        /*get option index from get_theme_mod()*/

        $index = get_theme_mod('smartlib_layout_' . $type);

        //get category layout type

        $cat = get_query_var('cat');

        $cat_extra_data = get_option('category_' . $cat);

        $category_variant = isset($cat_extra_data['smartlib_layout_category']) ? (int)$cat_extra_data['smartlib_layout_category'] : 0;


        if (isset($post) && is_singular('page')) {
            $index = get_post_meta($post->ID, 'smartlib_layout_' . $type, true);
        }


        if ($index == '') {

            $index = get_theme_mod('smartlib_layout_default', 1);

        }

        if (isset($layout_class_array[$index]) && strlen($layout_class_array[$index]['sidebar']) > 0 && $category_variant != 1) {
            ?>
            <section id="sidebar"
                     class="<?php echo apply_filters('smartlib_sidebar_layout_class', 'col-sm-16 col-md-4', $layout_class_array[$index]['sidebar']) ?>">
                <?php

                $this->smartlib_get_sidebar($type); //get sidebar based on configuration

                ?>
            </section>
        <?php

        }

    }

    /**
     * @param string $type - context or type sidebar param
     */
    public function smartlib_get_sidebar($type = 'default')
    {


        echo apply_filters('smartlib_before_sidebar', '<ul class="smartlib-layout-list smartlib-column-list smartlib-sm-2-columns-list">', $type) ?>
        <?php

        dynamic_sidebar($this->smartlib_get_context_sidebar($type));//get sidebar based on configuration

        ?>
        <?php echo apply_filters('smartlib_after_sidebar', '</ul>', $type) ?>

    <?php

    }

    /**
     * Return awesome icon based on key_class
     *
     * @param $key_class
     */

    /**
     * Get sidebar key based on context index
     * see $assign_context_sidebar in class-config.php file
     *
     * @param string $type
     *
     * @return mixed
     */
    private function smartlib_get_context_sidebar($type = 'default')
    {
        $assign_context_sidebar = $this->default_config->assign_context_sidebar;
        if (isset($assign_context_sidebar[$type][1])) {
            return $assign_context_sidebar[$type][1];
        } else {
            return $assign_context_sidebar['default'][1];
        }

    }

    public function smartlib_author_line($type = '')
    {

        $type = $this->get_context_type($type);

        $option = (int)$this->smartlib_get_option('smartlib_show_author_', $type);


        if ($option == 1) {
            ?>
            <span
                class="smartlib-metaline smartlib-author-line vcard"><?php _e('Published by: ', 'bootframe-core') ?> <?php the_author_posts_link(); ?> </span>
        <?php

        }
    }

    /**
     * Prints tag line with HTML
     */
    public function smartlib_entry_tags($type = 'blog_loop')
    {
        $option = (int)get_theme_mod('smartlib_show_tags_' . $type, 1);
        ?>
        <?php if (has_tag() && $option == 1): ?>
        <div class="smartlib_entry_tags">
            <i class="fa fa-tags"></i> <?php the_tags(__('Tags: ', 'bootframe-core'), '  '); ?>
        </div>
    <?php endif ?>
    <?php

    }

    /**
     * Custom form password
     *
     * @since BootFrame 1.0
     * @return string
     */

    public function smartlib_password_form()
    {
        global $post;
        $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
        $o = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post" class="password-form"><div class="row"><div class="sixteen"><i class="icon-lock icon-left"></i>' . __("To view this protected post, enter the password below:", 'bootframe-core') . '</div><label for="' . $label . '" class="four mobile-four">' . __("Password:", 'bootframe-core') . ' </label><div class="eight mobile-four"><input name="post_password" id="' . $label . '" type="password" size="20" /></div><div class="four mobile-four"><input type="submit" name="Submit" value="' . esc_attr__("Submit", 'bootframe-core') . '" /></div>
    </div></form>
    ';
        return $o;
    }

    /**
     * Return version of homepage layout
     * 1 - blog + sidebar
     * 2 - classic blog
     *
     * @return mixed
     */
    public function smartlib_version_homepage()
    {

        $version = get_theme_mod('project_homepage_version');
        if (empty($version)) {
            //return default (first value)
            return 1;
        }
        return $version;

    }

    public function smartlib_sticky_post_slider()
    {


        $sticky = get_option('sticky_posts');

        $args = array(
            'post__in' => $sticky,
        );

        $slider_news = new WP_Query($args);
        if ($slider_news->have_posts()) {
            ?>

            <!-- Front Page Slider -->
            <div class="smartlib-front-slider">
                <ul class="slides">
                    <?php
                    while ($slider_news->have_posts()) {
                        $slider_news->the_post();

                        require_once locate_template('/views/snippets/sticky-slider.php');

                    }
                    ?>
                </ul>
            </div>
            <!-- .End Front Page Slider -->
            <?php

            wp_reset_postdata();
        }
    }

    /**
     * Athor avatar action
     */
    function smartlib_author_avatar()
    {

        $option = (int)get_theme_mod('smartlib_show_avatar', 1);

        $author_meta_image = isset($this->default_config->layout_class_array['author_meta_image'])
            ? $this->default_config->layout_class_array['author_meta_image'] : '';
        if ($option == 1) {
            ?>
            <div class="author-avatar">
                <?php
                $user_image = get_the_author_meta($author_meta_image, get_the_author_meta('ID'));
                if (!empty($user_image)) {
                    ?>
                    <img src="<?php echo $user_image ?>"
                         alt="<?php printf(__('About %s', 'smartlib'), get_the_author()); ?>"/>
                <?php

                } else
                    echo get_avatar(get_the_author_meta('user_email'), apply_filters('smartlib_author_bio_avatar_size', 68)); ?>
            </div>
        <?php

        }

    }

    /**
     *  Return value form  $this->icon_awesome_translate_class
     *
     * @param $key
     *
     * @return mixed|void
     */
    public function get_awesome_icon_class($key)
    {

        $icon_awesome_translate_class = $this->default_config->icon_awesome_translate_class;

        if (isset($icon_awesome_translate_class[$key])) {
            $icon_class = $icon_awesome_translate_class[$key];
        } else {
            $icon_class = $icon_awesome_translate_class['default_icon'];
        }

        return apply_filters('smartlib_icon_class', $icon_class);
    }

    /**
     * Display social links
     */
    public function smartlib_social_links_area($show_option)
    {
        global $post;

        if ($show_option == 1) {

            $facebook = get_theme_mod('smartlib_social_facebook_button_default', '1');
            $twitter = get_theme_mod('smartlib_social_twitter_button_default', '1');
            $pinterest = get_theme_mod('smartlib_social_pinterest_button_default', '1');
            $gplus = get_theme_mod('smartlib_social_gplus_button_default', '1');

            ?>
            <ul class="smartlib-single-article-social-buttons pull-right">
                <?php
                if ($facebook == '1') {

                    ?>
                    <li>
                        <div class="fb-like" data-href="<?php get_permalink($post->ID) ?>" data-layout="box_count"
                             data-action="like" data-show-faces="false" data-share="false"></div>
                    </li>
                <?php
                }
                ?>

                <?php
                if ($twitter == '1') {
                    ?>
                    <li><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></li>

                <?php
                }
                ?>
                <?php
                if ($pinterest == '1') {
                    ?>
                    <li style="padding-top: 25px;"><a data-pin-config="above" href="//pinterest.com/pin/create/button/"
                                                      data-pin-do="buttonBookmark"><img
                                src="//assets.pinterest.com/images/pidgets/pin_it_button.png"/></a></li>

                <?php
                }
                ?>

                <?php
                if ($gplus == '1') {
                    ?>
                    <li>
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                        <g:plusone></g:plusone>
                    </li>

                <?php
                }
                ?>
            </ul>
        <?php
        }
    }


    /**
     * Show preloader
     */
    public function smartlib_preloader()
    {

        $show_preloader = get_theme_mod('smartlib_show_preloader', 1);

        if ($show_preloader == 1) {
            ?>
            <div class="smartlib-pre-loader">
                <div class="smartlib-load-icon">

                    <div class="smartlib-spinner">
                        <i class="fa fa-spinner fa-pulse  fa-3x fa-spin"></i>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    /**
     * Display image page header
     */
    function smartlib_single_page_header()
    {

        global $post;

        if (is_page() && !is_front_page()) {
            require_once locate_template('/views/snippets/header-single-page.php');
        }
        ?>

    <?php

    }


    function smartlib_display_top_bar($type = 'default')
    {
        global $post;

        $meta_option = '';

        $option = (int)$this->smartlib_get_option('smartlib_show_top_bar_', $type, 1);

        if (isset($post->ID))
            $meta_option = get_post_meta($post->ID, 'smartlib_show_top_bar_page', true);

        if (strlen($meta_option) > 0) {
            $option = (int)$meta_option;
        }

        if ($option == 1)
            require_once locate_template('/views/snippets/top-bar.php');

    }

    /**
     * Display Search Form
     */
    function smartlib_top_search($type = 'default')
    {
        $option = (int)$this->smartlib_get_option('smartlib_show_search_in_navbar_', $type, 2);

        if ($option == 2)
            require_once locate_template('/views/snippets/top-search.php');
    }

    function smartlib_social_links($area = 'top')
    {

        $config_media_options = $this->default_config->supported_social_media;


        $option = (int)get_theme_mod('smartlib_display_social_links_' . $area, 1);

        $i = 1;
        if ($option == 1) {
            ?>
            <ul class="list-inline  smartlib-social-icons-navbar pull-right">

                <?php
                foreach ($config_media_options as $key => $row) {
                    $link = get_theme_mod('smartlib_socialmedia_link_' . $key, 1);
                    if (strlen($link) > 4) {
                        ?>
                        <li><a href="<?php echo $link ?>"
                               class="smartlib-icon smartlib-small-square-icon smartlib-<?php echo $key ?>-ico"><i
                                    class="<?php echo apply_filters('smartlib_get_awesome_ico', 'fa fa-facebook', $key) ?>"></i></a>
                        </li>
                    <?php
                    }
                }
                ?>


            </ul>
        <?php
        }
    }


    /**
     * Display sidebar in footer
     *
     * @param string $type
     */
    function smartlib_footer_sidebar($type = 'default')
    {
        global $post;

        $meta_option = '';

        $show_sidebar = (int)get_theme_mod('smartlib_display_sidebar_footer_' . $type, '1');

        if (isset($post->ID)) {
            $meta_option = get_post_meta($post->ID, 'smartlib_display_sidebar_footer_page', true);
        }


        if (strlen($meta_option) > 0) {
            $show_sidebar = (int)$meta_option;
        }


        if ($show_sidebar == 1) {
            ?>
            <section class="smartlib-content-section smartlib-dark-section smartlib-full-width-section">
                <div class="container smartlib-footer-sidebar">

                    <div class="row">
                        <?php
                        dynamic_sidebar('sidebar-footer');
                        ?>
                    </div>
                </div>
            </section>
        <?php
        }
    }

    /**
     * Display Go to To button
     */
    function smartlib_go_top_button()
    {

        $show_button = get_theme_mod('smartlib_display_go_top_link_footer', '1');

        if ($show_button == '1') {
            ?>
            <a href="#" class="btn btn-primary smartlib-btn-go-top animated" id="scroll-top-top"><i
                    class="fa fa-chevron-up"></i></a>
        <?php
        }

    }

    function smartlib_site_title(){
        if(version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' )){
            ?>
            <title><?php wp_title( '|', true, 'right' ); ?></title>
        <?php
        }

    }

}



?>