<?php

/**
 * PROJECT CUSTOMIZER OPTIONS CLASS
 * Includes layout settings
 */
class Smartlib_Customizer_Options
{


    public $options = array();
    static $default_config;


    public function __construct($oConfig){

        self::$default_config = $oConfig;

    }

    public function controls_array()
    {


        $this->options['smartlib_show_preloader'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_preloader',
            'label' => __('Enabling this option will display animation while page loads', 'bootframe-core'),
            'section' => 'smartlib_section_preloader',
            'default' => 1,
            'priority' => 1,
            'choices' => array(
                0 => __('Hide', 'bootframe-core'),
                1 => __('Show', 'bootframe-core')
            )


        );


        $this->options['section_smartlib_gallery_pretty_photo'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'section_smartlib_gallery_pretty_photo',
            'label' => __('Enabling this option will display photos using prettyPhoto lightbox', 'bootframe-core'),
            'section' => 'section_smartlib_gallery_default',
            'default' => 1,
            'priority' => 1,
            'choices' => array(
                0 => __('OFF', 'bootframe-core'),
                1 => __('ON', 'bootframe-core')
            )
        );

        $this->options['section_smartlib_gallery_pretty_photo'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'section_smartlib_gallery_pretty_photo',
            'label' => __('Enabling this option will display photos using prettyPhoto lightbox', 'bootframe-core'),
            'section' => 'section_smartlib_gallery_default',
            'default' => 1,
            'priority' => 1,
            'choices' => array(
                0 => __('OFF', 'bootframe-core'),
                1 => __('ON', 'bootframe-core')
            )


        );


        $this->options['custom_code_header'] = array(
            'type' => 'textarea',
            'setting' => 'custom_code_header',
            'label' => __('Custom Scripts for Header [header.php]', 'bootframe-core'),
            'section' => 'section_smartlib_custom_code',

            'priority' => 1,
        );

        $this->options['custom_code_footer'] = array(
            'type' => 'textarea',
            'setting' => 'custom_code_footer',
            'label' => __('Custom Scripts for Footer [footer.php]', 'bootframe-core'),
            'section' => 'section_smartlib_custom_code',

            'priority' => 1,
        );


        $this->options['smartlib_layout_width'] = array(
            'type' => 'slider',
            'setting' => 'smartlib_layout_width',
            'label' => __('Page Width', 'bootframe-core'),
            'section' => 'smartlib_layout',
            'default' => 1200,
            'priority' => 3,
            'choices' => array(
                'min' => 960,
                'max' => 1500,
                'step' => 1,
            ),
        );

        $this->options['smartlib_section_smartlib_sidebar_resize'] = array(
            'type' => 'slider',
            'setting' => 'smartlib_section_smartlib_sidebar_resize',
            'label' => __('Sidebar Width', 'bootframe-core'),
            'section' => 'smartlib_layout',
            'default' => 320,
            'priority' => 4,
            'choices' => array(
                'min' => 200,
                'max' => 400,
                'step' => 1,
            ),
        );


        $this->options['smartlib_layout_default'] = array(
            'type' => 'radio',
            'mode' => 'image',
            'setting' => 'smartlib_layout_default',
            'label' => __('Default Layout Settings:', 'bootframe-core'),
            'section' => 'smartlib_layout',
            'priority' => 1,
            'default' => 1,
            'choices' => array(
                0 => SMART_KIRKI_URI . 'assets/images/1c.png',
                1 => SMART_KIRKI_URI . '/assets/images/2cr.png',
                2 => SMART_KIRKI_URI . '/assets/images/2cl.png',
            )
        );





        /*
                 * BLOG SETTINGS
                 */
        /*default*/
        $this->options['smartlib_pagination_posts'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_pagination_posts',
            'label' => __('Pagination', 'bootframe-core'),
            'section' => 'smartlib_blog_settings',
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '0' => __('Hide', 'bootframe-core'),
                '1' => __('Prev/Next', 'bootframe-core'),
                '2' => __('Numbers', 'bootframe-core'))
        );

        $this->options['smartlib_show_author_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_author_default',
            'label' => __('Show Author (Default)', 'bootframe-core'),
            'section' => 'smartlib_blog_settings',
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '0' => __('OFF', 'bootframe-core'),
                '1' => __('ON', 'bootframe-core'))
        );

        $this->options['smartlib_show_date_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_date_default',
            'label' => __('Show Date (Default)', 'bootframe-core'),
            'section' => 'smartlib_blog_settings',
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '0' => __('OFF', 'bootframe-core'),
                '1' => __('ON', 'bootframe-core'))
        );

        $this->options['smartlib_show_category_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_category_default',
            'label' => __('Show Categories (Default)', 'bootframe-core'),
            'section' => 'smartlib_blog_settings',
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '0' => __('OFF', 'bootframe-core'),
                '1' => __('ON', 'bootframe-core'))
        );

        $this->options['smartlib_show_postformat_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_postformat_default',
            'label' => __('Show Post Format (Default)', 'bootframe-core'),
            'section' => 'smartlib_blog_settings',
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '0' => __('OFF', 'bootframe-core'),
                '1' => __('ON', 'bootframe-core'))
        );


        /*Pages*/


        $this->options['smartlib_pages_breadcrumb_page'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_pages_breadcrumb_page',
            'label' => __('Show Breadcrumb:', 'bootframe-core'),
            'section' => 'smartlib_pages_settings',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                0 => __('Off', 'bootframe-core'),
                1 => __('On', 'bootframe-core'))
        );

        $this->options['smartlib_breadcrumb_separator_page'] = array(
            'type' => 'text',
            'setting' => 'smartlib_breadcrumb_separator_page',
            'label' => __('Breadcrumb separator:', 'bootframe-core'),
            'section' => 'smartlib_pages_settings',
            'default' => ' / ',
            'priority' => 10,

        );

        $this->options['smartlib_breadcrumb_homepage_name'] = array(
            'type' => 'text',
            'setting' => 'smartlib_breadcrumb_homepage_name',
            'label' => __('Breadcrumb Home Page Name:', 'bootframe-core'),
            'section' => 'smartlib_pages_settings',
            'default' => __('Home', 'bootframe-core'),
            'priority' => 10,

        );


     /*
     * Add Custom Navbar
     */



        $this->options['smartlib_show_top_bar_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_top_bar_default',
            'label' => __('Show Top Bar', 'bootframe-core'),
            'section' => 'smartlib_topbar_section',
            'default' => '1',
            'priority' => 5,
            'choices' => array(
                '0' => __('OFF', 'bootframe-core'),
                '1' => __('ON', 'bootframe-core'))
        );

        $this->options['smartlib_display_social_links_top'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_display_social_links_top',
            'label' => __('Display social buttons in top bar', 'bootframe-core'),
            'section' => 'smartlib_topbar_section',
            'priority' => 10,
            'default' => '1',
            'choices' => array(
                '0' => __('Off', 'bootframe-core'),
                '1' => __('On', 'bootframe-core')
            )
        );

        /*main navbar*/

        $this->options['smartlib_show_search_in_navbar_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_show_search_in_navbar_default',
            'label' => __('Search in navigation area', 'bootframe-core'),
            'section' => 'smartlib_header_section',
            'default' => '2',
            'priority' => 3,
            'choices' => array(
                '1' => __('Off', 'bootframe-core'),
                '2' => __('On', 'bootframe-core'))
        );

        $this->options['smartlib_fixed_navbar_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_fixed_navbar_default',
            'label' => __('Fixed Top Navbar', 'bootframe-core'),
            'section' => 'smartlib_header_section',
            'default' => '2',
            'priority' => 1,
            'choices' => array(
                '1' => __('Off', 'bootframe-core'),
                '2' => __('On', 'bootframe-core'))
        );

        $this->options['smartlib_ingrid_navbar_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_ingrid_navbar_default',
            'label' => __('In Grid Navbar', 'bootframe-core'),
            'section' => 'smartlib_header_section',
            'active_callback' => array('__SMARTLIB_HELPERS', 'conditional_navbar_is_fixed'),
            'default' => '1',
            'priority' => 1,
            'choices' => array(
                '1' => __('Off', 'bootframe-core'),
                '2' => __('On', 'bootframe-core'))
        );


        $this->options['smartlib_navbar_over_content_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_navbar_over_content_default',
            'label' => __('Display navbar over content', 'bootframe-core'),
            'description' => __('You can also change this setting on every single page. At this point, choose option which you will use most often', 'bootframe-core'),
            'section' => 'smartlib_header_section',
            'default' => '0',
            'priority' => 2,
            'choices' => array(
                '0' => __('Off', 'bootframe-core'),
                '1' => __('On', 'bootframe-core'))
        );



        /*Main Menu*/

        $this->options['smartlib_menu_fonts'] = array(
            'type' => 'select',
            'label' => __('Menu Font Family', 'bootframe-core'),
            'section' => 'smartlib_main_menu_section',
            'setting' => 'smartlib_menu_fonts',
            'default' => self::$default_config->smartlib_fonts['smartlib_menu_fonts'],
            'priority' => 1,
            'choices' => Kirki_Fonts::get_font_choices()
        );

        $this->options['smartlib_menu_link_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_menu_link_color_default',
            'label' => __('Links Color', 'bootframe-core'),
            'section' => 'smartlib_main_menu_section',
            'default' => '#ffffff',
            'priority' => 1,
        );

        $this->options['smartlib_menu_link_hover_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_menu_link_hover_color_default',
            'label' => __('Links Hover/Active Color', 'bootframe-core'),
            'section' => 'smartlib_main_menu_section',
            'default' => '#ffffff',
            'priority' => 2,
        );

        $this->options['smartlib_menu_link_hover_background_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_menu_link_hover_background_default',
            'label' => __('Links Hover/Active Background', 'bootframe-core'),
            'section' => 'smartlib_main_menu_section',
            'default' => '#ffffff',
            'priority' => 4,
        );

     /*
    * Add Custom Footer Controls
    */


        $this->options['smartlib_display_sidebar_footer_default'] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => 'smartlib_display_sidebar_footer_default',
            'label' => __('Display sidebar in footer', 'bootframe-core'),
            'section' => 'smartlib_footer_section',
            'priority' => 1,
            'default' => '1',
            'choices' => array(
                '0' => __('Off', 'bootframe-core'),
                '1' => __('On', 'bootframe-core')
            )
        );

        $this->options['smartlib_sidebar_background_footer_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_sidebar_background_footer_default',
            'label' => __('Footer Sidebar Background', 'bootframe-core'),
            'section' => 'smartlib_footer_section',
            'default' => '#2c3f52',
            'priority' => 2,
        );

        $this->options['smartlib_header_footer_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_header_footer_color_default',
            'label' => __('Footer Headers Color', 'bootframe-core'),
            'section' => 'smartlib_footer_section',
            'default' => '#1bb999',
            'priority' => 3,
        );




        /*
        * Add Custom Fonts & Colors
        */

        /*General Text Settings*/

        $this->options['smartlib_general_font_family_default'] = array(
            'type' => 'select',
            'label' => __('Font Family', 'bootframe-core'),
            'section' => 'smartlib_general_text_styles',
            'setting' => 'smartlib_general_font_family_default',
            'description' => __('Choose a default font for your site', 'bootframe-core'),
            'default' => self::$default_config->smartlib_fonts['smartlib_general_fonts'],
            'priority' => 1,
            'choices' => Kirki_Fonts::get_font_choices()
        );

        $this->options['smartlib_general_text_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_general_text_color_default',
            'label' => __('Text Color', 'bootframe-core'),
            'section' => 'smartlib_general_text_styles',
            'default' => '#2c3f50',
            'priority' => 2,
        );

        /*Header 1 styles*/

        $this->options['smartlib_h1_font_family_default'] = array(
            'type' => 'select',
            'label' => __('H1 Font Family', 'bootframe-core'),
            'section' => 'smartlib_header1_styles',
            'setting' => 'smartlib_h1_font_family_default',
            'description' => __('Choose a default font family for H1 heading', 'bootframe-core'),
            'default' => self::$default_config->smartlib_fonts['smartlib_h1_font_family_default'],
            'priority' => 1,
            'choices' => Kirki_Fonts::get_font_choices()
        );

        $this->options['smartlib_h1_text_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_h1_text_color_default',
            'label' => __('H1 Text Color', 'bootframe-core'),
            'section' => 'smartlib_header1_styles',
            'default' => '#2c3f50',
            'priority' => 2,
        );

        $this->options['smartlib_h1_text_size_default'] = array(
            'type' => 'slider',

            'setting' => 'smartlib_h1_text_size_default',
            'label' => __('H1 Font Size (px)', 'bootframe-core'),
            'section' => 'smartlib_header1_styles',
            'default' => 65,
            'priority' => 3,
            'choices' => array(
                'min' => 30,
                'max' => 80,
                'step' => 1,
            ),
        );

        $this->options['smartlib_h1_text_transform_default'] = array(
            'type' => 'select',

            'setting' => 'smartlib_h1_text_transform_default',
            'label' => __('H1 Text Transform', 'bootframe-core'),
            'section' => 'smartlib_header1_styles',
            'priority' => 3,
            'default' => 'uppercase',
            'choices' => array(
                'none' => __('None', 'bootframe-core'),
                'uppercase' => __('Uppercase', 'bootframe-core')
            )
        );

        $this->options['smartlib_h1_text_bolding_default'] = array(
            'type' => 'select',
            'mode' => 'buttonset',
            'setting' => 'smartlib_h1_text_bolding_default',
            'label' => __('H1 Font Weight', 'bootframe-core'),
            'section' => 'smartlib_header1_styles',
            'priority' => 4,
            'default' => 'normal',
            'choices' => array(
                'normal' => __('Normal', 'bootframe-core'),
                'bold' => __('Bold', 'bootframe-core')
            )
        );

        /*Header 2 styles*/
        $this->options['smartlib_h2_font_family_default'] = array(
            'type' => 'select',
            'label' => __('H2 Font Family', 'bootframe-core'),
            'section' => 'smartlib_header2_styles',
            'setting' => 'smartlib_h2_font_family_default',
            'description' => __('Choose a default font family for H1 heading', 'bootframe-core'),
            'default' => self::$default_config->smartlib_fonts['smartlib_h1_font_family_default'],
            'priority' => 1,
            'choices' => Kirki_Fonts::get_font_choices()
        );

        $this->options['smartlib_h2_text_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_h2_text_color_default',
            'label' => __('H2 Text Color', 'bootframe-core'),
            'section' => 'smartlib_header2_styles',
            'default' => '#2c3f50',
            'priority' => 2,
        );

        $this->options['smartlib_h2_text_size_default'] = array(
            'type' => 'slider',

            'setting' => 'smartlib_h2_text_size_default',
            'label' => __('H2 Font Size (px)', 'bootframe-core'),
            'section' => 'smartlib_header2_styles',
            'default' => 52,
            'priority' => 3,
            'choices' => array(
                'min' => 25,
                'max' => 70,
                'step' => 1,
            ),
        );



        /*Link section*/
        $this->options['smartlib_link_text_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_link_text_color_default',
            'label' => __('Links Text Color', 'bootframe-core'),
            'section' => 'smartlib_link_styles',
            'default' => '#1bbc9d',
            'priority' => 1,
        );

        $this->options['smartlib_link_hover_text_color_default'] = array(
            'type' => 'color',

            'setting' => 'smartlib_link_hover_text_color_default',
            'label' => __('Links Hover Text Color', 'bootframe-core'),
            'section' => 'smartlib_link_styles',
            'default' => '#2c3f52',
            'priority' => 2,
        );


        /*
        * BUTTONS
        */


        /*default button*/

        $this->options['smartlib_default_button_background'] = array(
            'type' => 'color',
            'setting' => 'smartlib_default_button_background',
            'label' => __('Background Default Button', 'bootframe-core'),
            'section' => 'smartlib_section_default_button',
            'priority' => 2,
        );

        $this->options['smartlib_default_button_hover_background'] = array(
            'type' => 'color',
            'setting' => 'smartlib_default_button_hover_background',
            'label' => __('Background Default Button Hover', 'bootframe-core'),
            'section' => 'smartlib_section_default_button',
            'priority' => 2,
        );








        /*primary button*/

        $this->options['smartlib_primary_button_background'] = array(
            'type' => 'color',
            'setting' => 'smartlib_primary_button_background',
            'label' => __('Background  Button', 'bootframe-core'),
            'section' => 'smartlib_section_primary_button',
            'priority' => 2,
        );

        $this->options['smartlib_primary_button_hover_background'] = array(
            'type' => 'color',
            'setting' => 'smartlib_primary_button_hover_background',
            'label' => __('Background Button Hover', 'bootframe-core'),
            'section' => 'smartlib_section_primary_button',
            'priority' => 2,
        );



        /*success button*/



        /*info button*/







        return $this->options;
    }
}


