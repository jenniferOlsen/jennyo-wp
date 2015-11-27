<?php

/**
 * PROJECT CONFIG CLASS
 * Includes layout settings
 */
class Smartlib_Config
{

    private static $instance;
    public  $customizer_control;

    private function __construct()
    {
        $this->customizer_control  = new Smartlib_Customizer_Options($this);
    }

    public $excerpt_length = 20;
    public $theme_prefix = 'smartlib';
    public static $theme_key = 'bstarter';

    /*define project menu*/

    public $project_menus = array(
        'top_pages' => 'Top Pages Menu',
        'main_menu' => 'Main Menu',

    );

    /*define project sidebars*/
    public $project_sidebars = array(
        'main_sidebar' => array(

            'name' => 'Main Sidebar',
            'description' => 'Appears on  Front Page',
            'before_widget' => '<li><div id="%1$s" class="panel widget smartlib-widget %2$s">',
            'after_widget' => '</div></li>',
            'before_title' => '<header class="panel-heading smartlib-widget-header"><h3 class="panel-title">',
            'after_title' => '</h3></header>',
        ),
        'frontpage_content_sidebar' => array(
            'name' => 'Frontpage Content',
            'description' => 'Appears on Category page',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>'
        ),
        'page_sidebar' => array(
            'name' => 'Default Page Sidebar',
            'description' => 'Default sidebar on the page',
            'before_widget' => '<li id="%1$s" class="widget %2$s"><div id="%1$s" class="panel widget smartlib-widget %2$s">',
            'after_widget' => '</div></li>',
            'before_title' => '<header class="panel-heading smartlib-widget-header"><h3 class="panel-title">',
            'after_title' => '</h3></header>'
        ),
        'sidebar-footer' => array(
            'name' => 'Sidebar Footer',
            'description' => 'Appears in footer',
            'before_widget' => '<div class="col-lg-3 col-sm-6"><div id="%1$s" class="smartlib-inside-box panel widget-no-padding smartlib-widget %2$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<header class="panel-heading"><h3 class="widget-title smartlib-header-with-decorator">',
            'after_title' => '</h3></header>'
        ),


    );

    public $assign_context_sidebar = array(
        'default' => array('<ul class="smartlib-layout-list">', 'main_sidebar', '</ul>'),

        'frontpage_content' => array('<ul class="smartlib-layout-list">', 'main_sidebar', '</ul>'),
        'page' => array('<ul class="smartlib-layout-list">', 'page_sidebar', '</ul>'),
    );

    //contains all customizer settings which goes to css header output
    public $css_propeties_array = array(
        'main_font_color' => array(
            'property' => 'color',
            'selectors' => 'body,p,h1,h2,h3,h4,h5,h6'
        ),
        'header_color' => array(
            'property' => 'color',
            'selectors' => 'h1,h2,h3,h4,h5,h6, .entry-title a'
        ),
        'sidebar_color' => array(
            'property' => 'background',
            'selectors' => '.widget-title'
        ),
        'link_color' => array(
            'property' => 'color',
            'selectors' => 'a, p a'
        ),
        'smartlib_menu_fonts'=> array(
            'property' => 'font-family',
            'selectors' => '.smartlib-default-top-navbar .smartlib-navbar-menu a'
        ),

        'smartlib_menu_link_color_default'=> array(
            'property' => 'color',
            'selectors' => '.smartlib-default-top-navbar .smartlib-navbar-menu li a'
        ),
        'smartlib_menu_link_hover_color_default'=> array(
            'property' => 'color',
            'selectors' => '.smartlib-default-top-navbar .smartlib-navbar-menu li a:hover'
        ),

        'smartlib_menu_text_transform_default'=> array(
            'property' => 'text-transform',
            'selectors' => '.smartlib-default-top-navbar .smartlib-navbar-menu a'
        ),

        'smartlib_menu_bolding_default'=> array(
            'property' => 'font-weight',
            'selectors' => '.smartlib-default-top-navbar .smartlib-navbar-menu a'
        ),

        'smartlib_menu_decoration_color_default'=> array(
            'property' => 'background',
            'selectors' => '.smartlib-navbar-menu li a:before'
        ),

        'smartlib_menu_icon_color_default'=> array(
            'property' => 'color',
            'selectors' => '.smartlib-search-navigation-area .smartlib-navbar-search-form .btn'
        ),

        'smartlib_menu_link_hover_background_default'=> array(
            'property' => 'background',
            'selectors' => '.smartlib-bottom-navbar .smartlib-navbar-menu li a:hover,.smartlib-bottom-navbar .smartlib-navbar-menu li.active a'
        ),

        /*footer*/

        'smartlib_sidebar_background_footer_default'=> array(
            'property' => 'background',
            'selectors' => '.smartlib-footer-area .smartlib-dark-section'
        ),
        'smartlib_header_footer_color_default'=> array(
            'property' => 'color',
            'selectors' => '.smartlib-footer-area .smartlib-widget h3'
        ),
        'smartlib_decorator_color_default'=> array(
            'property' => 'background',
            'selectors' => '.smartlib-footer-area h3.smartlib-header-with-decorator:after'
        ),
        'smartlib_text_footer_color_default'=> array(
            'property' => 'color',
            'selectors' => '.smartlib-footer-area .smartlib-widget, .smartlib-footer-area .smartlib-dark-section *,.smartlib-footer-area .smartlib-widget a, .smartlib-footer-area .smartlib-widget li, .smartlib-footer-area .smartlib-widget p'
        ),
        'smartlib_border_color_default'=> array(
            'property' => 'border-color',
            'selectors' => '.smartlib-footer-sidebar .smartlib-widget'
        ),

        /*heading*/

        //h1
        'smartlib_h1_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h1'
        ),
        'smartlib_h1_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h1'
        ),
        'smartlib_h1_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h1'
        ),

        'smartlib_h1_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h1'
        ),
        'smartlib_h1_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h1'
        ),


        //h2
        'smartlib_h2_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h2'
        ),
        'smartlib_h2_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h2'
        ),
        'smartlib_h2_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h2'
        ),

        'smartlib_h2_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h2'
        ),
        'smartlib_h2_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h2'
        ),

        //h3
        'smartlib_h3_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h3'
        ),
        'smartlib_h3_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h3'
        ),
        'smartlib_h3_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h3'
        ),

        'smartlib_h3_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h3'
        ),
        'smartlib_h3_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h3'
        ),

        //h4
        'smartlib_h4_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h4'
        ),
        'smartlib_h4_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h4'
        ),
        'smartlib_h4_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h4'
        ),

        'smartlib_h4_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h4'
        ),
        'smartlib_h4_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h4'
        ),

        //h5
        'smartlib_h5_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h5'
        ),
        'smartlib_h5_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h5'
        ),
        'smartlib_h5_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h5'
        ),

        'smartlib_h5_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h5'
        ),
        'smartlib_h5_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h5'
        ),


        //h6
        'smartlib_h6_font_family_default'=> array(
            'property' => 'font-family',
            'selectors' => 'h6'
        ),
        'smartlib_h6_text_color_default'=> array(
            'property' => 'color',
            'selectors' => 'h6'
        ),
        'smartlib_h6_text_size_default'=> array(
            'property' => 'font-size',
            'unit'=> 'px',
            'selectors' => 'h6'
        ),

        'smartlib_h6_text_transform_default' => array(
            'property' => 'text-transform',
            'selectors' => 'h6'
        ),
        'smartlib_h6_text_bolding_default' => array(
            'property' => 'font-weight',
            'selectors' => 'h6'
        ),

        /*links*/
        'smartlib_link_text_color_default' => array(
            'property' => 'color',
            'selectors' => 'a'
        ),
        'smartlib_link_hover_text_color_default' => array(
            'property' => 'color',
            'selectors' => 'a:hover, a:focus'
        ),

        /*BUTTONS*/

        /*default*/

        'smartlib_default_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-default:before'
        ),

        'smartlib_default_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-default:hover:after'
        ),

        'smartlib_default_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-default'
        ),

        'smartlib_default_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-default'
        ),

        'smartlib_default_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-default'
        ),

        'smartlib_default_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-default'
        ),

        /*primary*/

        'smartlib_primary_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-primary:before'
        ),

        'smartlib_primary_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-primary:hover:after'
        ),

        'smartlib_primary_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-primary'
        ),

        'smartlib_primary_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-primary'
        ),

        'smartlib_primary_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-primary'
        ),

        'smartlib_primary_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-primary'
        ),

        /*success*/

        'smartlib_success_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-success:before'
        ),

        'smartlib_success_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-success:hover:after'
        ),

        'smartlib_success_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-success'
        ),

        'smartlib_success_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-success'
        ),

        'smartlib_success_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-success'
        ),

        'smartlib_success_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-success'
        ),

        /*info*/

        'smartlib_info_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-info:before'
        ),

        'smartlib_info_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-info:hover:after'
        ),

        'smartlib_info_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-info'
        ),

        'smartlib_info_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-info'
        ),

        'smartlib_info_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-info'
        ),

        'smartlib_info_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-info'
        ),

        /*warning*/

        'smartlib_warning_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-warning:before'
        ),

        'smartlib_warning_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-warning:hover:after'
        ),

        'smartlib_warning_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-warning'
        ),

        'smartlib_warning_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-warning'
        ),

        'smartlib_warning_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-warning'
        ),

        'smartlib_warning_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-warning'
        ),

        /*danger*/

        'smartlib_danger_button_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-danger:before'
        ),

        'smartlib_danger_button_hover_background' => array(
            'property' => 'background',
            'selectors' => '.btn.btn-danger:hover:after'
        ),

        'smartlib_danger_button_text_color' => array(
            'property' => 'color',
            'selectors' => '.btn.btn-danger'
        ),

        'smartlib_danger_button_border_color' => array(
            'property' => 'border-color',
            'selectors' => '.btn.btn-danger'
        ),

        'smartlib_danger_button_font_family' => array(
            'property' => 'font-family',
            'selectors' => '.btn.btn-danger'
        ),

        'smartlib_danger_button_text_transform' => array(
            'property' => 'text-transform',
            'selectors' => '.btn.btn-danger'
        ),



    );

    public $premium_sections_array =  array(

       
        'smartlib_main_menu_section',
        'smartlib_header_section',
        'smartlib_header2_styles',
        'smartlib_header3_styles',
        'smartlib_header4_styles',
        'smartlib_header5_styles',
        'smartlib_header6_styles',
        'smartlib_section_default_button',
        'smartlib_section_primary_button',
        'smartlib_section_success_button',
        'smartlib_section_info_button',
        'smartlib_section_warning_button',
        'smartlib_section_danger_button',
        'smartlib_footer_section',
        'smartlib_layout',
        'smartlib_blog_settings'
    );

    public $smartlib_safe_fonts = array(
        'Verdana' => array(
            'label' => 'Verdana'
        ),
        'Arial' => array(
            'label' => 'Arial'
        )
    );

    public $smartlib_fonts = array(
        'smartlib_general_fonts' => 'Noto Sans',
        'smartlib_menu_fonts' => 'Roboto',
        'smartlib_header_fonts' => 'Arial',
        'smartlib_h1_font_family_default' => 'Roboto',
        'smartlib_h2_font_family_default'=> 'Roboto',
        'smartlib_h3_font_family_default'=> 'Roboto',
        'smartlib_h4_font_family_default'=> 'Roboto',
        'smartlib_h5_font_family_default'=> 'Roboto',
        'smartlib_h6_font_family_default'=> 'Roboto',
        'smartlib_default_button_font_family'=> 'Roboto',
    );

    public static $promoted_formats = array(
        'video', 'gallery'
    );

    public $layout_class_array = array(
        0 => array(

            'sidebar' => '',

            'content' => 'smartlib-no-sidebar'
        ),
        1 => array(

            'sidebar' => 'smartlib-right-sidebar',

            'content' => 'smartlib-left-content'
        ),
        2 => array(

            'sidebar' => 'smartlib-left-sidebar',

            'content' => 'smartlib-right-content'
        ),


    );


    public $layout_sizes = array(
        'layout' => array(
            'size' => 1200,
            'container' => '.container, .smartlib-content-section,.smartlib-full-strech-section .panel-row-style',
            'customizer_key' => 'smartlib_layout_width'
        ),
        'sidebar' => array(
            'size' => 320,
            'container' => '#sidebar',
            'customizer_key' => 'smartlib_section_smartlib_sidebar_resize'
        ),
        'content' => array(
            'size' => array('layout', 'sidebar'),//first  param: minuend ; second param: subtrahend
            'container' => '#page',
            'customizer_key' => ''
        ),
    );
    /*
         * Array maping awesome class
         */
    public $icon_awesome_translate_class = array(
        'gallery' => 'fa fa-picture-o',
        'video' => 'fa fa-video-camera',
        'default_icon' => 'fa fa-caret-square-o-right',
        'tag_icon' => 'fa fa-tags',
        'twitter' => 'fa fa-twitter',
        'facebook' => 'fa fa-facebook',
        'gplus' => 'fa fa-google-plus',
        'pinterest' => 'fa fa-pinterest-p',
        'linkedin' => 'fa fa-linkedin-square',
        'youtube' => 'fa fa-youtube',
        'twitter_large' => 'fa fa-twitter',
        'facebook_large' => 'fa fa-facebook',
        'gplus_large' => 'fa fa-google-plus',
        'pinterest_large' => 'fa fa-pinterest-p',
        'linkedin_large' => 'fa fa-linkedin',
        'youtube_large' => 'fa fa-youtube',
        'comments' => 'fa fa-comment',
        'more-link' => 'fa fa-angle-right',
        'rss' => 'fa fa-rss',
        'email' => 'fa fa-envelope'
    );

    public $supported_social_media = array(
        'facebook' => 'Facebook', 'gplus' => 'Google Plus', 'pinterest' => 'Pinterest', 'twitter' => 'Twitter', 'rss' => 'RSS'
    );

    /* Meta keys array*/

    public $smartlib_meta_keys = array(
        'author_meta_image' => 'smartlib_profile_image'
    );


    public function get_promoted_formats()
    {
        return self::$promoted_formats;
    }

    public function get_theme_key()
    {
        return self::$theme_key;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Smartlib_Config();

        }
        return self::$instance;
    }
}