<?php

/**
 * Smartlib Widgets Classes
 *
 * Theme's widgets extends the default WordPress
 * widgets by giving users highly-customizable widget settings.
 *
 * @subpackage Smartlib
 * @since      Smartlib 1.0
 */


/**
 * Custom Search widget class
 *
 * @since 1.0
 */
class Smart_Widget_Search extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'bootframe_widget_search', 'description' => __("A search form for your site", 'bootframe-core'));
        parent::__construct('search', __(ucfirst('bootframe-core') . 'Search', 'bootframe-core'), $widget_ops);
    }

    function widget($args, $instance)
    {

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $args['before_widget'];
        if ($title)
            echo $args['before_title'] . $title . $args['after_title'];

        ?>
        <div class="panel-body smartlib-inside-box">
            <?php
            get_search_form();
            ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => ''));
        $title = $instance['title'];

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat"
                       id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text"
                       value="<?php echo esc_attr($title); ?>"/></label>
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array)$new_instance, array('title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

}

/**
 * Recent_Posts widget class
 *
 * @since 1.0
 *
 */
class Smart_Widget_Recent_Posts extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-last-articles-widget', 'description' => __("The most recent posts on your site (extended contorls)", 'bootframe-core'));
        parent::__construct('smartlib-recent-posts', __(ucfirst('bootframe-core') . ' Extended Recent Posts', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries_Smartlib';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        $cache = wp_cache_get('smartlib-recent-posts', 'widget');

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'bootframe-core') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 10;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        $show_post_thumbnail = isset($instance['show_post_thumbnail']) ? $instance['show_post_thumbnail'] : true;

        $show_post_author = isset($instance['show_post_author']) ? $instance['show_post_author'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true)));
        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title']; ?>
        <div class="smartlib-inside-box panel-body">
            <?php

            if ($r->have_posts()) :
                ?>
                <ul class="smartlib-layout-list smartlib-vertical-list">
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <li class="smartlib-content-with-separator">
                            <div class="row">
                                <div class="col-xs-4 smartlib-no-padding-right">
                                    <?php
                                    if ('' != get_the_post_thumbnail() && $show_post_thumbnail) {
                                        ?>

                                        <a href="<?php the_permalink() ?>"
                                           class="smartlib-widget-image-outer"><?php the_post_thumbnail('smartlib-medium-square'); ?>
                                        </a>

                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-xs-8">

                                    <h4 class="widget-post-title"><a
                                            href="<?php the_permalink() ?>"><?php if (get_the_title()) the_title();
                                            else the_ID(); ?></a></h4>

                                    <p class="smartlib-meta-line">
                                        <?php do_action('smartlib_date_and_link', 'blog_loop') ?>
                                        <?php do_action('smartlib_author_line', 'blog_loop') ?>
                                    </p>

                                </div>
                            </div>
                        </li>
                    <?php endwhile;

                    wp_reset_postdata();
                    ?>
                </ul>
            <?php
            endif;
            ?>
        </div>
        <?php echo $args['after_widget']; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();


        /*
                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
        
            */
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int)$new_instance['number'];
        $instance['show_date'] = (bool)isset($new_instance['show_date'])?1:0;
        $instance['show_post_thumbnail'] = (bool)isset($new_instance['show_post_thumbnail'])?1:0;
        $instance['show_post_author'] = (bool)isset($new_instance['show_post_author'])?1:0;

        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_recent_entries']))
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form($instance)
    {


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : false;
        $show_post_thumbnail = isset($instance['show_post_thumbnail']) ? (bool)$instance['show_post_thumbnail'] : true;
        $show_post_author = isset($instance['show_post_author']) ? (bool)$instance['show_post_author'] : true;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

        <p>
            <label
                for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'bootframe-core'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>"
                   type="text" value="<?php echo $number; ?>" size="3"/></p>

        <p><input class="checkbox" type="checkbox" <?php checked($show_date); ?>
                  id="<?php echo $this->get_field_id('show_date'); ?>"
                  name="<?php echo $this->get_field_name('show_date'); ?>"/>
            <label
                for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?', 'bootframe-core'); ?></label>
        </p>

        <p><input class="checkbox" type="checkbox" <?php checked($show_post_thumbnail); ?>
                  id="<?php echo $this->get_field_id('show_post_thumbnail'); ?>"
                  name="<?php echo $this->get_field_name('show_post_thumbnail', 'bootframe-core'); ?>"/>
            <label
                for="<?php echo $this->get_field_id('show_post_thumbnail'); ?>"><?php _e('Display post thumbnail?', 'bootframe-core'); ?></label>
        </p>

        <p><input class="checkbox" type="checkbox" <?php checked($show_post_author); ?>
                  id="<?php echo $this->get_field_id('show_post_author'); ?>"
                  name="<?php echo $this->get_field_name('show_post_author'); ?>"/>
            <label
                for="<?php echo $this->get_field_id('show_post_author'); ?>"><?php _e('Display post author?', 'bootframe-core'); ?></label>
        </p>
    <?php
    }
}


/**
 * One author info widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_One_Author extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'bootframe_one_author', 'description' => __("Short  info & avatar", 'bootframe-core'));
        parent::__construct('bootframe_one-author', __(ucfirst('bootframe-core') . ' One Author Profile', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-one-author';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        wp_reset_postdata();
        $title = apply_filters('widget_title', $instance['title']);


        $author = get_userdata($instance['user_id']);


        $name = $author->display_name;

        $avatar = get_avatar($instance['user_id'], $instance['size']);
        $description = get_the_author_meta('description', $instance['user_id']);
        $author_link = get_author_posts_url($instance['user_id']);


        ?>

        <?php echo $args['before_widget']; ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title']; ?>
        <div class="smartlib-inside-box panel-body">
            <span class="widget-image-outer"><?php echo $avatar ?></span>
            <h4><a href="<?php echo $author_link ?>"><?php echo $name ?></a></h4>

            <p class="description-widget"><?php echo $description ?></p>
            <?php echo $args['after_widget']; ?>
        </div>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['size'] = strip_tags($new_instance['size']);
        $instance['user_id'] = strip_tags($new_instance['user_id']);

        return $instance;
    }

    function form($instance)
    {
        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('user_id', $instance)) {
            $user_id = esc_attr($instance['user_id']);
        } else {
            $user_id = 1;
        }

        if (array_key_exists('size', $instance)) {
            $size = esc_attr($instance['size']);
        } else {
            $size = 64;
        }

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat"
                       id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text"
                       value="<?php echo $title; ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e('Authot Name:', 'bootframe-core'); ?>
                <select id="<?php echo $this->get_field_id('user_id'); ?>"
                        name="<?php echo $this->get_field_name('user_id'); ?>" value="<?php echo $user_id; ?>">
                    <?php

                    $args = array(
                        'order' => 'ASC'
                    );

                    $users = get_users($args);;

                    foreach ($users as $row) {
                        echo "<option value='$row->ID' " . ($row->ID == $user_id ? "selected='selected'" : '') . ">$row->user_nicename</option>";
                    }
                    ?>
                </select></label></p>
        <p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Avatar Size:', 'bootframe-core'); ?>
                <select id="<?php echo $this->get_field_id('size'); ?>"
                        name="<?php echo $this->get_field_name('size'); ?>"
                        value="<?php echo $size; ?>">
                    <?php
                    for ($i = 16; $i <= 256; $i += 16) {
                        echo "<option value='$i' " . ($size == $i ? "selected='selected'" : '') . ">$i</option>";
                    }
                    ?>
                </select></label></p>
    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('bootframe_one_author', 'widget');
    }
}


/**
 * Add social profile icons -  widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Social_Icons extends WP_Widget
{

    public $form_args;

    function __construct()
    {
        $widget_ops = array('classname' => 'bootframe_widget_social_icons', 'description' => __("Add social profile icons", 'bootframe-core'));
        parent::__construct('smartlib-social-icons', __(ucfirst('bootframe-core') . '  Social Icons', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-social-icons';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));

        $this->form_args = array(
            'title',
            'facebook',
            'gplus',
            'twitter',
            'youtube',
            'pinterest',
            'linkedin',
            'rss'

        );
    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);


        echo $args['before_widget'];
        ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title']; ?>
        <div class="smartlib-inside-box panel-body">
            <ul class="smartlib-layout-list smartlib-horizontal-list">
                <?php
                foreach ($this->form_args as $row) {
                    if (isset($instance[$row]) && !empty($instance[$row]) && $row != 'title') {
                        ?>
                        <li><a href="<?php echo $instance[$row] ?>"
                               class="smartlib-icon smartlib-large-square-icon smartlib-<?php echo $row ?>-ico"><i
                                    class="<?php echo apply_filters('smartlib_get_awesome_ico', 'fa fa-share', $row); ?>"></i></a>
                        </li>
                    <?php
                    }
                } ?>
            </ul>
        </div>
        <?php
        echo $args['after_widget']; ?>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        foreach ($this->form_args as $row) {
            $instance[$row] = strip_tags($new_instance[$row]);
        }

        return $instance;
    }

    function form($instance)
    {

        $form_values = array();

        foreach ($this->form_args as $row) {
            if (array_key_exists($row, $instance)) {
                $form_values[$row] = $instance[$row];
            } else {
                $form_values[$row] = '';
            }
        }

        ?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Short Title:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $form_values['title']; ?>" /></label>
	<hr />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $form_values['facebook']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('gplus'); ?>"><?php _e('Google+:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('gplus'); ?>" name="<?php echo $this->get_field_name('gplus'); ?>" type="text" value="<?php echo $form_values['gplus']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo $form_values['youtube']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $form_values['twitter']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo $form_values['pinterest']; ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('LinkedIn:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $form_values['linkedin']; ?>" /></label>
	</p>



	<?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-social-icons', 'widget');
    }
}


/**
 * Featured Video Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Video extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'bootframe-video_widget', 'description' => __("Featured Video Widget", 'bootframe-core'));
        parent::__construct('bootframe-video-widget', __(ucfirst('bootframe-core') . ' Video Widget', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'widget_bootframe-video-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $embed_code = $instance['embed_code'];
        $more_text = $instance['more_text'];
        $link = strlen($instance['link'])>0?$instance['link']:'#';


        echo $args['before_widget'];

        ?>
        <?php if ($title) echo apply_filters('smartlib_widget_before_title', $args['before_title'], $instance) . $title . apply_filters('smartlib_widget_after_title', $args['after_title'], $instance); ?>

        <div class="smartlib-inside-box panel-body">
        <?php echo $embed_code ?>

        <?php
        if (strlen($more_text) > 0) {
            ?>
            <a href="<?php echo $link ?>" class="btn btn-primary more-link pull-right"><?php echo $more_text ?></a>
            </div>
        <?php
        }
        ?>

        <?php
        echo $args['after_widget']; ?>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['embed_code'] = $new_instance['embed_code'];
        $instance['more_text'] = $new_instance['more_text'];
        $instance['link'] = $new_instance['link'];

        return $instance;
    }

    function form($instance)
    {

        $form_values = array();

        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('embed_code', $instance)) {
            $embed_code = esc_attr($instance['embed_code']);
        } else {
            $embed_code = '';
        }

        if (array_key_exists('more_text', $instance)) {
            $more_text = esc_attr($instance['more_text']);
        } else {
            $more_text = '';
        }
        if (array_key_exists('link', $instance)) {
            $link = esc_attr($instance['link']);
        } else {
            $link = '';
        }

        ?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
	<hr />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('embed_code'); ?>"><?php _e('Embed code:', 'bootframe-core'); ?><br />
			<textarea id="<?php echo $this->get_field_id('embed_code'); ?>" name="<?php echo $this->get_field_name('embed_code'); ?>" rows="5" cols="40"><?php echo $embed_code; ?></textarea></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('more_text'); ?>"><?php _e('More text:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" type="text" value="<?php echo $more_text; ?>" /></label>

	</p>
	<p>
		<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', 'bootframe-core'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></label>

	</p>

	<?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-video-widget', 'widget');
    }
}


/**
 * Recent Video Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Recent_Videos extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib-video_widget', 'description' => __("Displays last posts from the video post format", 'bootframe-core'));
        parent::__construct('smartlib-recent-video-widget', __(ucfirst('bootframe-core') . '  Recent Video', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-recent-videos-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        $limit = is_int($instance['video_limit']) ? $instance['video_limit'] : 4;


        echo $args['before_widget'];
        ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <div class="smartlib-inside-box panel-body">
            <?php

            $query = new WP_Query(
                array(
                    'posts_per_page' => $limit,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-video')
                        )
                    )
                )
            );
            if ($query->have_posts()) {
                ?>

                <ul class="smartlib-layout-list smartlib-column-list smartlib-graph-columns smartlib-2-columns-list">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        if ('' != get_the_post_thumbnail()) {
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"
                                   class="smartlib-thumbnail-outer"><?php the_post_thumbnail('medium-square') ?></a>
                            </li>

                        <?php
                        }
                    }
                    ?></ul>

            <?php
            }
            wp_reset_postdata();
            ?>
        </div>
        <?php
        echo $args['after_widget']; ?>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['video_limit'] = $new_instance['video_limit'];

        return $instance;
    }

    function form($instance)
    {

        $form_values = array();

        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('video_limit', $instance)) {
            $limit = esc_attr($instance['video_limit']);
        } else {
            $limit = '';
        }



        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>

        </p>

        <p>
            <label for="<?php echo $this->get_field_id('video_limit'); ?>"><?php _e('Limit:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('video_limit'); ?>"
                       name="<?php echo $this->get_field_name('video_limit'); ?>" type="text"
                       value="<?php echo $limit; ?>"/></label>

        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-recent-video-widget', 'widget');
    }
}

/**
 * Add Recent Gallery Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Recent_Galleries extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib_gallery_recent_widget', 'description' => __("Displays last posts from the gallery post format", 'smartlib'));
        parent::__construct('smartlib-recent-gallery-widget', __(ucfirst('bootframe-core') . '  Recent Galleries', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-gallery_recent_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        $limit = is_int($instance['gallery_limit']) ? $instance['gallery_limit'] : 4;


        echo $args['before_widget'];
        ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <div class="smartlib-inside-box panel-body">
            <?php

            $query = new WP_Query(
                array(
                    'posts_per_page' => $limit,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-gallery')
                        )
                    )
                )
            );
            if ($query->have_posts()) {
                ?>


                <ul class="smartlib-layout-list smartlib-column-list smartlib-graph-columns smartlib-2-columns-list">
                    <?php
                    while ($query->have_posts()) {

                        $query->the_post();

                        ?>

                        <?php

                        if ('' != get_the_post_thumbnail()) {
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"
                                   class="smartlib-thumbnail-outer"><?php the_post_thumbnail('medium-square') ?></a>
                            </li>
                        <?php
                        } else if (!empty($featured_image)) {
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"
                                   class="smartlib-thumbnail-outer"><?php echo $featured_image ?></a></li>
                        <?php

                        }
                        ?>

                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>



            <?php
            }

            ?>
        </div>

        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['gallery_limit'] = $new_instance['gallery_limit'];

        return $instance;
    }

    function form($instance)
    {

        $form_values = array();

        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('gallery_limit', $instance)) {
            $limit = esc_attr($instance['gallery_limit']);
        } else {
            $limit = '';
        }



        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>

        </p>

        <p>
            <label for="<?php echo $this->get_field_id('gallery_limit'); ?>"><?php _e('Limit:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('gallery_limit'); ?>"
                       name="<?php echo $this->get_field_name('gallery_limit'); ?>" type="text"
                       value="<?php echo $limit; ?>"/></label>

        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-recent-gallery-widget', 'widget');
    }

}


/**
 * Extend content widget
 *
 * @since 1.0
 *
 */
class Smart_Extend_Content extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib_extend_content', 'description' => __("Extend Content", 'bootframe-core'));
        parent::__construct('smartlib_extend_content', __(ucfirst('bootframe-core') . ' Extend Content', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-extend-content';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {


        $title = apply_filters('widget_title', $instance['title']);

        $box_image = isset($instance['box_image']) ? $instance['box_image'] : '';
        $box_text = isset($instance['box_text']) ? $instance['box_text'] : '';

        $box_page_id = isset($instance['box_page_id']) ? (int)$instance['box_page_id'] : '';
        $box_external_link = isset($instance['box_external_link']) ? $instance['box_external_link'] : '';

        ?>

        <?php echo $args['before_widget'];
        ?>
        <div class="panel smartlib-center-align smartlib-widget smartlib-icon-feture-box">

            <span class="widget-image-outer"><img src="<?php echo $box_image ?>" alt="<?php echo $title ?>"/></span>

            <div class="panel-body">
                <h4><?php echo $title ?></h4>

                <p class="description-widget"><?php echo $box_text ?></p>
                <?php
                $link_href = '';

                if (strlen($box_external_link) > 0) {
                    $link_href = $box_external_link;
                } else if ($box_page_id) {
                    $link_href = get_permalink($box_page_id);
                }

                if (strlen($link_href) > 0) {
                    ?>

                    <a href="<?php echo $link_href ?>"
                       class="btn btn-default"><?php _e('Learn More', 'bootframe-core') ?></a>
                <?php
                }
                ?>
            </div>
        </div>
        <?php echo $args['after_widget']; ?>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['box_image'] = strip_tags($new_instance['box_image']);
        $instance['box_text'] = strip_tags($new_instance['box_text']);
        $instance['box_page_id'] = (int)$new_instance['box_page_id'];
        $instance['box_external_link'] = strip_tags($new_instance['box_external_link']);


        return $instance;
    }

    function form($instance)
    {
        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('box_text', $instance)) {

            $box_text = esc_attr($instance['box_text']);
        } else {
            $box_text = '';
        }

        if (array_key_exists('box_page_id', $instance)) {

            $box_page_id = esc_attr($instance['box_page_id']);
        } else {
            $box_page_id = 0;
        }
        if (array_key_exists('box_external_link', $instance)) {

            $box_external_link = esc_attr($instance['box_external_link']);
        } else {
            $box_external_link = '';
        }


        if (array_key_exists('box_image', $instance)) {
            $box_image = esc_attr($instance['box_image']);
        } else {
            $box_image = '';
        }

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat"
                       id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text"
                       value="<?php echo $title; ?>"/></label>

        </p>
        <p><label for="<?php echo $this->get_field_id('box_image'); ?>"><?php _e('Box image:', 'bootframe-core'); ?><br/>
                <input class="smartlib-media-input"
                       id="<?php echo $this->get_field_id('box_image'); ?>"
                       name="<?php echo $this->get_field_name('box_image'); ?>"
                       type="hidden"
                       value="<?php echo $box_image; ?>"/>
                <a href="#" class="smartlib-media-button button-primary so-close"
                   onclick="bstarter_admin.common.click_manager_init(this)">Dodaj Plik</a>
                <span class="smartlib-image-area">
                    <?php
                    if (strlen($box_image) == 0) {
                        ?>
                        <img
                            src="<?php echo get_template_directory_uri() ?>/assets/img/logo-1.png"/>
                    <?php
                    } else {
                        ?>
                        <img
                            src="<?php echo $box_image ?>"/>
                    <?php
                    }
                    ?>
                </span>
        </p>
        <p><label for="<?php echo $this->get_field_id('box_text'); ?>"><?php _e('Box Text:', 'bootframe-core'); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id('box_text'); ?>"
                          name="<?php echo $this->get_field_name('box_text'); ?>"
                          ?><?php echo $box_text; ?></textarea>

        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('box_page_id'); ?>"><?php _e('Box read more link', 'bootframe-core') ?></label><br/>
            <?php wp_dropdown_pages(array('name' => $this->get_field_name('box_page_id'), 'id' => $this->get_field_id('box_page_id'), 'show_option_none' => __('Choose Page', 'bootframe-core'), 'selected' => $box_page_id)); ?>
        </p>
        <p><label
                for="<?php echo $this->get_field_id('box_external_link'); ?>"><?php _e('External link', 'bootframe-core') ?></label><br/>
            <input
                id="<?php echo $this->get_field_id('box_external_link'); ?>"
                name="<?php echo $this->get_field_name('box_external_link'); ?>"
                type="text"
                value="<?php echo $box_external_link; ?>"/>
        </p>
    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib_extend_contentr', 'widget');
    }
}


/**
 * Contact Form & Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Contact_Form extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-contact-form-widget', 'description' => __("Display Contact Form 7 form in Your sidebar", 'bootframe-core'));
        parent::__construct('smartlib-contact-form-widget', __(ucfirst('bootframe-core') . ' Contact Form 7 Form', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-contact-form-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        $cache = wp_cache_get('smartlib-contact-form-widget', 'widget');

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Contact Form', 'bootframe-core') : $instance['title'], $instance, $this->id_base);

        $form_id = isset($instance['form_id']) ? $instance['form_id'] : false;
        if ($form_id) {
            $contact_form = get_post($form_id);
        }


        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ($title) echo apply_filters('smartlib_widget_before_title', $args['before_title'], $instance) . $title . apply_filters('smartlib_widget_after_title', $args['after_title'], $instance); ?>
        <div class="smartlib-inside-box panel-body">
            <?php
            if ($form_id) {
                echo do_shortcode('[contact-form-7 id="' . $contact_form->ID . '" title="' . $contact_form->post_title . '"]');
            }
            ?>
        </div>
        <?php echo $args['after_widget']; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();


        /*
                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set( 'widget_recent_posts', $cache, 'widget' );

            */
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['form_id'] = (int)$new_instance['form_id'];


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['smartlib-contact-form-widget']))
            delete_option('smartlib-contact-form-widget');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-contact-form-widget', 'widget');
    }

    function form($instance)
    {

        if (!defined('WPCF7_PLUGIN_NAME')) {
            ?>
            <p><?php _e('Please install Contact Form 7 plugin from', 'bootframe-core') ?> <a
                    href="https://wordpress.org/plugins/contact-form-7/">wordpress.org</a></p>
            <?php
            return;
        }

        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $form_id = isset($instance['form_id']) ? $instance['form_id'] : 5;

        $post_args = array('post_type' => 'wpcf7_contact_form');
        $contact_forms = get_posts($post_args);

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

        <p>
            <label for="<?php echo $this->get_field_id('form_id'); ?>"><?php _e('Select Form:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('form_id'); ?>"
                    name="<?php echo $this->get_field_name('form_id'); ?>" class="widefat" style="width:100%;">
                <?php
                foreach ($contact_forms as $contact_form) {
                    ?>
                    <option <?php echo $contact_form->ID == $form_id ? 'selected="selected"' : '' ?>
                        value="<?php echo $contact_form->ID; ?>"><?php echo $contact_form->post_title; ?></option>
                <?php
                }
                ?>
            </select>
        </p>


    <?php
    }
}


/**
 * Add Section header widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Section_Header extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib-header-section-widget', 'description' => __("Section Header", 'bootframe-core'));
        parent::__construct('smartlib-header-section-widget', __(ucfirst('bootframe-core') . '  Section Header', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-header-section-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        $header_subtitle = strlen($instance['header_subtitle']) > 0 ? $instance['header_subtitle'] : '';
        $header_align = strlen($instance['header_align']) > 0 ? $instance['header_align'] : 'left';
        $header_size = strlen($instance['header_size']) ? $instance['header_size'] : 'large';

        ?>
        <?php echo $args['before_widget']; ?>
            <header
                class="smartlib-section-header<?php echo apply_filters('smartlib_algin_text', 'text-center', $header_align); ?>">
                <h2 class="<?php echo 'smartlib-header-' . $header_size ?>"><?php echo $title ?></h2>
                <?php
                if (strlen($header_align) > 0) {
                    ?>
                    <p><?php echo $header_subtitle ?></p>
                <?php
                }
                ?>
            </header>
        <?php echo $args['after_widget']; ?>
    <?php

    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['header_size'] = strip_tags($new_instance['header_size']);
        $instance['header_align'] = $new_instance['header_align'];
        $instance['header_subtitle'] = $new_instance['header_subtitle'];

        return $instance;
    }

    function form($instance)
    {

        $form_values = array();

        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }
        if (array_key_exists('header_subtitle', $instance)) {
            $header_subtitle = esc_attr($instance['header_subtitle']);
        } else {
            $header_subtitle = '';
        }
        if (array_key_exists('header_align', $instance)) {
            $header_align = esc_attr($instance['header_align']);
        } else {
            $header_align = '';
        }
        if (array_key_exists('header_size', $instance)) {
            $header_size = esc_attr($instance['header_size']);
        } else {
            $header_size = '';
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>

        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('header_subtitle'); ?>"><?php _e('Header Subtitle:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('header_subtitle'); ?>"
                       name="<?php echo $this->get_field_name('header_subtitle'); ?>" type="text"
                       value="<?php echo $header_subtitle; ?>"/></label>

        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('header_align'); ?>"><?php _e('Header Align:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('header_align'); ?>"
                    name="<?php echo $this->get_field_name('header_align'); ?>" class="widefat" style="width:100%;">
                <option <?php echo $header_align == 'left' ? 'selected="selected"' : '' ?>
                    value="left"><?php _e('Left Align', 'bootframe-core'); ?></option>
                <option <?php echo $header_align == 'center' ? 'selected="selected"' : '' ?>
                    value="center"><?php _e('Center Align', 'bootframe-core'); ?></option>
                <option <?php echo $header_align == 'right' ? 'selected="selected"' : '' ?>
                    value="right"><?php _e('Right Align', 'bootframe-core'); ?></option>
            </select>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('header_size'); ?>"><?php _e('Header Size:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('header_size'); ?>"
                    name="<?php echo $this->get_field_name('header_size'); ?>" class="widefat" style="width:100%;">
                <option <?php echo $header_size == 'small' ? 'selected="selected"' : '' ?>
                    value="small"><?php _e('Small', 'bootframe-core'); ?></option>
                <option <?php echo $header_size == 'medium' ? 'selected="selected"' : '' ?>
                    value="medium"><?php _e('Medium', 'bootframe-core'); ?></option>
                <option <?php echo $header_size == 'large' ? 'selected="selected"' : '' ?>
                    value="large"><?php _e('Large', 'bootframe-core'); ?></option>
            </select>
        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-recent-gallery-widget', 'widget');
    }

}

/**
 * Portfolio Items Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Portfolio_Items extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib_portfolio_items_widget', 'description' => __("Displays last portfolio item", 'smartlib'));
        parent::__construct('smartlib_portfolio_items_widget', __(ucfirst('bootframe-core') . '  Portfolio Items', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib_portfolio_items_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        $limit = is_int($instance['items_limit']) ? $instance['items_limit'] : 4;
        $portfolio_taxonomy = strlen($instance['portfolio_taxonomy']) > 0 ? (int)$instance['portfolio_taxonomy'] : 0;

        echo $args['before_widget'];
        ?>
        <?php if ($title) echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <div class="smartlib-widget-content-area">
            <?php

            $query_args =
                array(
                    'posts_per_page' => $limit,
                    'post_type' => 'smartlib_portfolio',

                );

            if ($portfolio_taxonomy > 0) {

                $tax_query['tax_query'] = array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field' => 'ID',
                        'terms' => $portfolio_taxonomy
                    )
                );
                $query_args = array_merge($query_args, $tax_query);

            }


            $query = new WP_Query($query_args);

            if ($query->have_posts()) {
                ?>


                <ul class="smartlib-layout-list smartlib-column-list smartlib-graph-columns smartlib-<?php echo $limit ?>-columns-list">
                    <?php
                    while ($query->have_posts()) {

                        $query->the_post();
                        ?>

                        <li>
                            <div class="smartlib-widget panel smartlib-caption-box">

                                <div
                                    class="smartlib-thumbnail-outer"><?php the_post_thumbnail('smartlib-large-thumb') ?></div>

                                <div class="samrtlib-caption">
                                    <aside class="smartlib-graph-info-box">
                                        <h4><?php the_title() ?></h4>

                                        <p><?php the_excerpt() ?></p>

                                    </aside>
                                </div>
                                <div class="smartlib-caption-buttons-area"><a href="<?php the_permalink(); ?>"
                                                                              class="btn btn-primary smartlib-more-link"><?php _e('View More', 'bootframe-core') ?></a>
                                </div>
                            </div>

                        </li>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>



            <?php
            }

            ?>
        </div>

        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['items_limit'] = $new_instance['items_limit'];
        $instance['portfolio_taxonomy'] = isset($new_instance['portfolio_taxonomy'])?$new_instance['portfolio_taxonomy']:'';

        return $instance;
    }

    function form($instance)
    {
        if (!defined('SMARTLIB_PLUGIN_PATH')) {
            ?>
            <p><?php _e('Please install Smartlib Tools', 'bootframe-core') ?> </p>
            <?php
            return;
        }


        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('items_limit', $instance)) {
            $items_limit = esc_attr($instance['items_limit']);
        } else {
            $items_limit = 4;
        }

        if (array_key_exists('portfolio_taxonomy', $instance)) {
            $portfolio_taxonomy = esc_attr($instance['portfolio_taxonomy']);
        } else {
            $portfolio_taxonomy = 0;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>

        </p>
        <?php

        $terms = get_terms('portfolio_category');
        if (!empty($terms) && !is_wp_error($terms)) {
            ?>
            <p>
                <label
                    for="<?php echo $this->get_field_id('portfolio_taxonomy'); ?>"><?php _e('Portfolio Category:', 'bootframe-core'); ?>
                    <select name="<?php echo $this->get_field_name('portfolio_taxonomy'); ?>">
                        <option><?php _e('All', 'bootframe-core') ?></option>
                        <?php
                        foreach ($terms as $term) {
                            ?>
                            <option <?php echo $term->term_id == $portfolio_taxonomy ? 'selected="selected"' : '' ?>
                                value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                        <?php

                        }
                        ?>
                    </select>
            </p>
        <?php
        }

        ?>


        <p>
            <label
                for="<?php echo $this->get_field_id('items_limit'); ?>"><?php _e('How many items is displayed:', 'bootframe-core'); ?></label>
            <select name="<?php echo $this->get_field_name('items_limit'); ?>">
                <option <?php echo $items_limit == '2' ? 'selected="selected"' : '' ?> value="2">2</option>
                <option <?php echo $items_limit == '3' ? 'selected="selected"' : '' ?> value="3">3</option>
                <option <?php echo $items_limit == '4' ? 'selected="selected"' : '' ?> value="4">4</option>
                <option <?php echo $items_limit == '5' ? 'selected="selected"' : '' ?> value="5">5</option>
                <option <?php echo $items_limit == '6' ? 'selected="selected"' : '' ?> value="6">6</option>
            </select>


        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-recent-gallery-widget', 'widget');
    }

}

/**
 * Portfolio Items Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Last_Articles_Columns extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib_last_articles_columns_widget', 'description' => __("Displays the latest articles in Columns", 'smartlib'));
        parent::__construct('smartlib_last_articles_columns_widget', __(ucfirst('bootframe-core') . '  Last Articles in  Columns', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib_last_articles_columns_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {


        $limit = $instance['items_limit'] ? $instance['items_limit'] : 4;
        $articles_category = strlen($instance['articles_category']) > 0 ? (int)$instance['articles_category'] : 0;

        echo $args['before_widget'];
         echo  $args['after_title'];

        ?>

            <?php

            $query_args =
                array(
                    'posts_per_page' => $limit,
                    'post_type' => 'post',
                    'post__not_in' => get_option( 'sticky_posts' )

                );

            if ($articles_category > 0) {

                $query_args =
                    array(
                        'posts_per_page' => $limit,
                        'post_type' => 'post',
                        'cat' => $articles_category
                    );

            }


            $query = new WP_Query($query_args);

            if ($query->have_posts()) {
                ?>


                <ul class="smartlib-layout-list smartlib-column-list smartlib-<?php echo $limit ?>-columns-list">
                    <?php
                    while ($query->have_posts()) {

                        $query->the_post();
                        ?>

                        <li>
                            <div class="panel smartlib-inside-box smartlib-widget">
                                <?php smartlib_post_thumbnail_block('smartlib-large-thumb', 'default') ?>

                                <div class="panel-body">
                                    <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>

                                    <p><?php the_excerpt() ?></p>
                                    <a href="<?php the_permalink() ?>" class="btn btn-primary"><?php _e('Read more', 'sii'); ?></a>
                        	<span class="pull-right">
											<?php do_action('smartlib_comments_count', 'default'); ?>
										</span>
                                </div>
                            </div>

                        </li>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>



            <?php
            }

            ?>


        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['items_limit'] = $new_instance['items_limit'];
        $instance['articles_category'] = isset($new_instance['articles_category'])?$new_instance['articles_category']:'';

        return $instance;
    }

    function form($instance)
    {





        if (array_key_exists('items_limit', $instance)) {
            $items_limit = $instance['items_limit'];
        } else {
            $items_limit = 4;
        }

        if (array_key_exists('articles_category', $instance)) {
            $articles_category = esc_attr($instance['articles_category']);
        } else {
            $articles_category = 0;
        }

        ?>

        <?php

        $categories = get_categories();
        if (!empty($categories) && !is_wp_error($categories)) {
            ?>
            <p>
                <label
                    for="<?php echo $this->get_field_id('articles_category'); ?>"><?php _e('Category Articles:', 'bootframe-core'); ?>
                    <select name="<?php echo $this->get_field_name('articles_category'); ?>">
                        <option><?php _e('All', 'bootframe-core') ?></option>
                        <?php
                        foreach ($categories as $term) {
                            ?>
                            <option <?php echo $term->term_id == $articles_category ? 'selected="selected"' : '' ?>
                                value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                        <?php

                        }
                        ?>
                    </select>
            </p>
        <?php
        }

        ?>


        <p>
            <label
                for="<?php echo $this->get_field_id('items_limit'); ?>"><?php _e('How many items is displayed:', 'bootframe-core'); ?></label>
            <select name="<?php echo $this->get_field_name('items_limit'); ?>">
                <option <?php echo $items_limit == '2' ? 'selected="selected"' : '' ?> value="2">2</option>
                <option <?php echo $items_limit == '3' ? 'selected="selected"' : '' ?> value="3">3</option>
                <option <?php echo $items_limit == '4' ? 'selected="selected"' : '' ?> value="4">4</option>
                <option <?php echo $items_limit == '5' ? 'selected="selected"' : '' ?> value="5">5</option>
                <option <?php echo $items_limit == '6' ? 'selected="selected"' : '' ?> value="6">6</option>
            </select>


        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib_last_articles_columns_widget', 'widget');
    }

}

/**
 * Testimonial Items Widget
 *
 * @since 1.0
 *
 */
class Smart_Widget_Testimonial_Items extends WP_Widget
{


    function __construct()
    {
        $widget_ops = array('classname' => 'smartlib_testimonial_items_widget', 'description' => __("Displays testimonials", 'smartlib'));
        parent::__construct('smartlib_testimonial_items_widget', __(ucfirst('bootframe-core') . '  Testimonials', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib_testimonial_items_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));


    }

    function widget($args, $instance)
    {

        $title = apply_filters('widget_title', $instance['title']);

        $columns_per_slide = 2;

        $query_args =
            array(

                'post_type' => 'smartlib_testimonial',

            );
        $query_testimonial = new WP_Query($query_args);
        $limit = $query_testimonial->found_posts;

        ?>


        <?php echo $args['before_widget']; ?>

            <div class="smartlib-slider-container smartlib-center-align smartlib-slider-bottom-nav">
                <ul class="smartlib-layout-list smartlib-testimonial-slides slides">
                    <?php
                    $i = 1;
                    $j = 1;
                    while ($query_testimonial->have_posts()) {


                        $query_testimonial->the_post();

                        if ($i == 1) {
                            ?>
                            <li class="smartlib-testimonial-box">
                            <div class="row">
                        <?php
                        }
                        ?>
                        <div class="col-sm-6">


                            <div class="panel smartlib-center-align">
                                <div class="panel-body smartlib-inside-box">
                                    <p><?php the_content() ?></p>

                                    <div class="smartlib-image-with-text-left">
                                    <span
                                        class="smartlib-image-outer pull-left"><?php the_post_thumbnail('smartlib-small-square') ?></span>

                                        <p class="smartlib-testimonial-author">
                                            <strong><?php echo get_post_meta(get_the_ID(), 'stool_client_name', true); ?></strong><br/>
                                            <small><?php echo get_post_meta(get_the_ID(), 'stool_company_name', true); ?></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($i % $columns_per_slide == 0 || $j == $limit) {
                            ?>
                            </div>
                            </li>
                            <?php
                            $i = 1;
                        } else {
                            $i++;
                        }

                        $j++;

                    }// end while

                    wp_reset_postdata();

                    ?>

                </ul>
            </div>

        <?php echo $args['after_widget']; ?>
    <?php


    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form($instance)
    {
        if (!defined('SMARTLIB_PLUGIN_PATH')) {
            ?>
            <p><?php _e('Please install Smartlib Tools', 'bootframe-core') ?> </p>
            <?php
            return;
        }


        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>

        </p>

    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-recent-gallery-widget', 'widget');
    }

}

/**
 * Display Page Content
 *
 * @since 1.0
 *
 */
class Smart_Display_Page_Content extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-display_page-widget', 'description' => __("Display content from selected page", 'bootframe-core'));
        parent::__construct('smartlib-display_page-widget', __(ucfirst('bootframe-core') . ' Display Page Content', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-display_page-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        $cache = wp_cache_get('smartlib-display_page-widget', 'widget');

        $title = isset($instance['title']) ? $instance['title'] : false;

        $page_id = isset($instance['page_id']) ? $instance['page_id'] : false;

        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ($title) echo apply_filters('smartlib_widget_before_title', $args['before_title'], $instance) . $title . apply_filters('smartlib_widget_after_title', $args['after_title'], $instance); ?>
        <div class="smartlib-inside-box panel-body">
            <?php
            if ($page_id) {

                $query = new WP_Query(array('page_id' => $page_id));
                while ($query->have_posts()): $query->the_post();
                    the_content();
                endwhile;
            }
            wp_reset_postdata();
            ?>
        </div>
        <?php echo $args['after_widget']; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();


        /*
                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set( 'widget_recent_posts', $cache, 'widget' );

            */
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['page_id'] = (int)$new_instance['page_id'];


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['smartlib-contact-form-widget']))
            delete_option('smartlib-contact-form-widget');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-contact-form-widget', 'widget');
    }

    function form($instance)
    {


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $page_id = isset($instance['page_id']) ? $instance['page_id'] : 5;

        $post_args = array('post_type' => 'page');
        $pages = get_posts($post_args);

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Select Page:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('page_id'); ?>"
                    name="<?php echo $this->get_field_name('page_id'); ?>" class="widefat" style="width:100%;">
                <?php
                foreach ($pages as $page) {
                    ?>
                    <option <?php echo $page->ID == $page_id ? 'selected="selected"' : '' ?>
                        value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                <?php
                }
                ?>
            </select>
        </p>


    <?php
    }
}

/**
 * Simple Call to action
 *
 * @since 1.0
 *
 */
class Smart_Simple_Call_To_Action extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-simple-call-to-action', 'description' => __("Display call to action block", 'bootframe-core'));
        parent::__construct('smartlib-simple-call-to-action', __(ucfirst('bootframe-core') . ' Call to Action', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-simple-call-to-action';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {



        $title = isset($instance['title']) ? $instance['title'] : false;
        $box_text = isset($instance['box_text']) ? $instance['box_text'] : '';
        $page_id = (int)isset($instance['page_id']) ? $instance['page_id'] : false;
        $more_text =  isset($instance['more_text'])? $instance['more_text'] : '';
        $link = isset($instance['link'])? $instance['link'] : '#';
        $text_align = isset($instance['text_align'])? $instance['text_align']:'left';
        $link_align = isset($instance['link_align'])? $instance['link_align']:'left';

        $link_href = ($page_id>0)?get_permalink($page_id): $link;
        ?>
        <?php echo $args['before_widget']; ?>

        <div class="row">
<div class="col-md-12 <?php echo 'text-'.$text_align?>">
    <h2><?php echo $title ?></h2>
</div>
            <div class="<?php echo ($link_align!='center')?'col-md-8':'col-md-12'; ?><?php echo ($link_align=='left')?' col-md-push-3':'' ?>">
                <?php echo $box_text ?>
            </div>
            <div class="<?php echo ($link_align!='center')?'col-md-4':'col-md-12'; ?><?php echo ($link_align=='left')?' col-md-pull-9':'' ?>">
                <a href="<?php echo $link_href ?>" class="btn btn-lg btn-default <?php echo ($link_align=='right')?' pull-right':'' ?>"><?php echo $more_text ?></a>
            </div>

        </div>
        <?php echo $args['after_widget']; ?>
        <?php

    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['page_id'] = (int)$new_instance['page_id'];
        $instance['more_text'] = $new_instance['more_text'];
        $instance['box_text'] = $new_instance['box_text'];
        $instance['link'] = $new_instance['link'];
        $instance['link_align'] = $new_instance['link_align'];
        $instance['text_align'] = $new_instance['text_align'];


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['smartlib-simple-call-to-action']))
            delete_option('smartlib-simple-call-to-action');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-simple-call-to-action', 'widget');
    }

    function form($instance)
    {


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $page_id = isset($instance['page_id']) ? $instance['page_id'] : false;
        $box_text = isset($instance['box_text']) ? $instance['box_text'] : '';

        $more_text =  isset($instance['more_text'])? $instance['more_text'] : '';
        $link = isset($instance['link'])? $instance['link'] : '#';
        $text_align = isset($instance['text_align'])? $instance['text_align']:'left';
        $link_align = isset($instance['link_align'])? $instance['link_align']:'left';


        $post_args = array('post_type' => 'page');
        $pages = get_posts($post_args);



        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>
        <p>
            <label for="<?php echo $this->get_field_id('box_text'); ?>"><?php _e('Call to Action Text:', 'bootframe-core'); ?><br />
                <textarea id="<?php echo $this->get_field_id('box_text'); ?>" name="<?php echo $this->get_field_name('box_text'); ?>" rows="5" cols="40"><?php echo $box_text; ?></textarea></label>
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('text_align'); ?>"><?php _e('Text Align:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('text_align'); ?>"
                    name="<?php echo $this->get_field_name('text_align'); ?>" class="widefat" style="width:100%;">
                <option <?php echo $text_align == 'left' ? 'selected="selected"' : '' ?>
                    value="left"><?php _e('Left Align', 'bootframe-core'); ?></option>
                <option <?php echo $text_align == 'center' ? 'selected="selected"' : '' ?>
                    value="center"><?php _e('Center Align', 'bootframe-core'); ?></option>
                <option <?php echo $text_align == 'right' ? 'selected="selected"' : '' ?>
                    value="right"><?php _e('Right Align', 'bootframe-core'); ?></option>
            </select>
        </p>
       <fieldset class="postbox">
           <h3><?php _e('Button settings', 'bootframe-core') ?></h3>
           <p><label for="<?php echo $this->get_field_id('more_text'); ?>"><?php _e('Button Text:', 'bootframe-core'); ?></label>
               <input class="widefat" id="<?php echo $this->get_field_id('more_text'); ?>"
                      name="<?php echo $this->get_field_name('more_text'); ?>" type="text" value="<?php echo $more_text; ?>"/></p>
           <p>
           <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Destination URL:', 'bootframe-core'); ?></label>
               <input class="widefat" id="<?php echo $this->get_field_id('more_text'); ?>"
                      name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>"/></p>
           <p>
        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Select Page:', 'bootframe-core'); ?></label>
            <select id="<?php echo $this->get_field_id('page_id'); ?>"
                    name="<?php echo $this->get_field_name('page_id'); ?>" class="widefat" style="width:100%;">
                <?php
                foreach ($pages as $page) {
                    ?>
                    <option <?php echo $page->ID == $page_id ? 'selected="selected"' : '' ?>
                        value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
           <p>
               <label
                   for="<?php echo $this->get_field_id('link_align'); ?>"><?php _e('Button Align:', 'bootframe-core'); ?></label>
               <select id="<?php echo $this->get_field_id('link_align'); ?>"
                       name="<?php echo $this->get_field_name('link_align'); ?>" class="widefat" style="width:100%;">
                   <option <?php echo $link_align == 'left' ? 'selected="selected"' : '' ?>
                       value="left"><?php _e('Left Align', 'bootframe-core'); ?></option>
                   <option <?php echo $link_align == 'center' ? 'selected="selected"' : '' ?>
                       value="center"><?php _e('Center Align', 'bootframe-core'); ?></option>
                   <option <?php echo $link_align == 'right' ? 'selected="selected"' : '' ?>
                       value="right"><?php _e('Right Align', 'bootframe-core'); ?></option>
               </select>
           </p>
       </fieldset>

    <?php
    }
}

/**
 * Counter Box Widget
 *
 * @since 1.0
 *
 */
class Smart_Counter_Box extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-counter-box-widget', 'description' => __("Display animated counter box", 'bootframe-core'));
        parent::__construct('smartlib-counter-box-widget', __(ucfirst('bootframe-core') . ' Counter Boxes', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-counter-box-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        //$cache = wp_cache_get('smartlib-counter-box-widget', 'widget');

        $title = isset($instance['title']) ? $instance['title'] : false;


        $counter_area = array();
        $box_label = array();
        $j = 0;
        $columns = 0;
        for ($i = 0; $i < 5; $i++) {

            if (isset($instance['counter_area'][$i]) && strlen($instance['counter_area'][$i]) > 0) {
                $counter_area[$j] = $instance['counter_area'][$i];
                $columns++;
                if (isset($instance['box_label'][$i]))
                    $box_label[$j] = $instance['box_label'][$i];
                else
                    $box_label[$j] = '';
            }
            $j++;
        }


        if ($columns > 0)
            $column_size = 12 / $columns;
        else
            $column_size = 1;
        ?>



        <?php echo $args['before_widget']; ?>
            <div class="row">
                <?php
                for ($j = 0; $j < $columns; $j++) {
                    if (isset($counter_area[$j]) && strlen($counter_area[$j]) > 0) {
                        ?>

                        <div class="col-md-<?php echo $column_size ?>">
                            <div class="panel smartlib-center-align smartlib-counter-box">
                                <div class="smartlib-inside-box panel-body">
                        <span class="smartlib-counter" data-from="1"
                              data-to="<?php echo $counter_area[$j] ?>">0</span>

                                    <p><?php echo $box_label[$j] ?></p>
                                </div>
                            </div>

                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        <?php echo $args['after_widget']; ?>

        <?php


        /*
                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set( 'widget_recent_posts', $cache, 'widget' );

            */
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        $instance['counter_area'] = array();

        for ($i = 0; $i < 5; $i++) {
            $instance['counter_area'][$i] = $new_instance['counter_area'][$i];
            $instance['box_label'][$i] = $new_instance['box_label'][$i];
        }

        foreach ($instance['counter_area'] as $row) {

        }

        print_r($new_instance);


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['smartlib-counter-box-widget']))
            delete_option('smartlib-counter-box-widget');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-counter-box-widget', 'widget');
    }

    function form($instance)
    {


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';


        $counter_area = array();
        for ($i = 0; $i < 5; $i++) {

            $counter_area[$i] = isset($instance['counter_area'][$i]) ? $instance['counter_area'][$i] : '';
            $box_label[$i] = isset($instance['box_label'][$i]) ? $instance['box_label'][$i] : '';
        }


        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>
        <?php
        for ($i = 0; $i < 5; $i++) {
            ?>
            <fieldset>

                <p><label
                        for="<?php echo $this->get_field_id('box_label_'. $i); ?>"><?php _e('Box Label:', 'bootframe-core'); ?></label>
                    <input size="40" id="<?php echo $this->get_field_id('box_label_' . $i); ?>"
                           name="<?php echo $this->get_field_name('box_label'); ?>[<?php echo $i ?>]" type="text"
                           value="<?php echo isset($box_label[$i]) ? $box_label[$i] : ''; ?>"/></p>

                <p>
                    <label
                        for="<?php echo $this->get_field_id('counter_area_' . $i); ?>"><?php _e('Number:', 'bootframe-core'); ?></label>
                    <input id="<?php echo $this->get_field_id('counter_area_' . $i); ?>"
                           name="<?php echo $this->get_field_name('counter_area'); ?>[<?php echo $i ?>]" size="20"
                           type="text" value="<?php echo isset($counter_area[$i]) ? $counter_area[$i] : ''; ?>"/>
                </p>
                <hr/>
            </fieldset>
        <?php
        }
        ?>

    <?php
    }
}

/**
 * Our Team Box Widget
 *
 * @since 1.0
 *
 */
class Smart_Team_Box extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array('classname' => 'smartlib-team-box-widget', 'description' => __("Display your team members in columns", 'bootframe-core'));
        parent::__construct('smartlib-team-box-widget', __(ucfirst('bootframe-core') . ' Our Team Columns', 'bootframe-core'), $widget_ops);
        $this->alt_option_name = 'smartlib-team-box-widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

       // $cache = wp_cache_get('smartlib-team-box-widget', 'widget');

        $title = isset($instance['title']) ? $instance['title'] : false;


        $user_array = array();

        $j = 0;
        $columns = 0;
        for ($i = 0; $i < 4; $i++) {

            if (isset($instance['user_array'][$i]) && strlen($instance['user_array'][$i]) > 0) {

                $columns++;
                if (isset($instance['user_array'][$i]))
                    $user_array[$j] = $instance['user_array'][$i];
                else
                    $user_array[$j] = '';
            }
            $j++;
        }


        if ($columns > 0)
            $column_size = 12 / $columns;
        else
            $column_size = 1;
        ?>
            <div class="row">
                <?php


                for ($j = 0; $j < 4; $j++) {
                    if (isset($user_array[$j])) {
                        // $user_info = get_post($user_array[$j]);

                        ?>
                        <div class="col-md-<?php echo $column_size ?>">
                            <div class="panel  smartlib-center-align">
                                <div class="panel-body smartlib-inside-box">
                                    <?php echo get_the_post_thumbnail($user_array[$j], 'col-sm-square', array('class' => 'img-responsive img-circle')) ?>
                                    <h4><?php echo get_the_title($user_array[$j]) ?></h4>

                                    <p class="text-muted"><?php echo get_post_meta($user_array[$j], 'smartlib_member_position', true); ?></p>
                                    <?php
                                    //get social info
                                    $social_info = array();
                                    $social_info['email'] = get_post_meta($user_array[$j], 'smartlib_user_email', true);
                                    $social_info['twitter'] = get_post_meta($user_array[$j], 'smartlib_twitter_url', true);
                                    $social_info['facebook'] = get_post_meta($user_array[$j], 'smartlib_facebook_url', true);
                                    $social_info['pinterest'] = get_post_meta($user_array[$j], 'smartlib_pinterest_url', true);
                                    $social_info['linkedin'] = get_post_meta($user_array[$j], 'smartlib_linkedin_url', true);
                                    $social_info['gplus'] = get_post_meta($user_array[$j], 'smartlib_googlep_url', true);



                                    ?>

                                    <ul class="list-inline social-buttons">
                                        <?php
                                        foreach ($social_info as $key => $row) {
                                            if (strlen($row) > 0) {
                                                ?>
                                                <li><a href="<?php echo $row ?>"><i
                                                            class="<?php echo apply_filters('smartlib_get_awesome_ico', 'fa fa-share', $key); ?>"></i></a>
                                                </li>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    <?php
                    }
                }
                ?>
            </div>


        <?php


        /*
                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set( 'widget_recent_posts', $cache, 'widget' );

            */
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        $instance['user_array'] = array();

        for ($i = 0; $i < 4; $i++) {
            $instance['user_array'][$i] = $new_instance['user_array'][$i];
        }


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['smartlib-team-box-widget']))
            delete_option('smartlib-team-box-widget');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('smartlib-team-box-widget', 'widget');
    }

    function form($instance)
    {

        if (!defined('SMARTLIB_PLUGIN_PATH')) {
            ?>
            <p><?php _e('Please install Smartlib Tools', 'bootframe-core') ?> </p>
            <?php
            return;
        }


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';


        $user_array = array();
        for ($i = 0; $i < 4; $i++) {

            $user_array[$i] = isset($instance['user_array'][$i]) ? $instance['user_array'][$i] : '';

        }


        $post_args = array('post_type' => 'smartlib_team');
        $users = get_posts($post_args);

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bootframe-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>
        <?php
        for ($i = 0; $i < 4; $i++) {

            ?>
            <fieldset>

                <p>
                    <label
                        for="<?php echo $this->get_field_id('user_array_' . $i); ?>"><?php _e('Coulumn ', 'bootframe-core') . $i; ?></label>
                    <select id="<?php echo $this->get_field_id('user_array_' . $i); ?>"
                            name="<?php echo $this->get_field_name('user_array'); ?>[<?php echo $i ?>]" class="widefat"
                            style="width:100%;">
                        <option><?php _e('Select User', 'bootframe-core') ?></option>
                        <?php

                        foreach ($users as $user) {

                            ?>
                            <option <?php echo $user->ID == $user_array[$i] ? 'selected="selected"' : '' ?>
                                value="<?php echo $user->ID ?>"><?php echo $user->post_title; ?></option>
                        <?php

                        }
                        ?>
                    </select>
                </p>
            </fieldset>
        <?php
        }
        ?>

    <?php
    }
}






