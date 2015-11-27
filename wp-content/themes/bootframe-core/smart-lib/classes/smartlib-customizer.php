<?php

/**
 * Project Customizer Class
 *
 * Contains methods for customizing the theme customization screen.
 *
 *
 * @subpackage project
 * @since      project 1.0
 */
class Smartlib_Customizer
{


    public static $theme_key;
    public static $default_config;
    public static $controls_array;


    public function __construct()
    {

        self::$default_config = Smartlib_Config::getInstance();
        self::$theme_key = self::$default_config->get_theme_key();
        self::$controls_array = self::$default_config->customizer_control->controls_array();


        add_filter('kirki/controls', array($this, 'smartlib_kirki_controls'));

    }


    /**
     * Implement theme options into Theme Customizer on Frontend
     *
     * @see   examples for different input fields https://gist.github.com/2968549
     * @since 08/09/2012
     *
     * @param $wp_customize Theme Customizer object
     *
     * @return void
     */
    public function  register($wp_customize)
    {
        //add customizer sections
        $this->add_sections($wp_customize);
        $this->add_settings_controls($wp_customize);
        $this->smartlib_add_premium_info($wp_customize);
        $this->wp_customize = $wp_customize;
    }

    /*
     * Add Customizer Sections
     */

    private function add_sections($wp_customize)
    {


        $wp_customize->add_panel( 'smartlib_panel_general_settings', array(
            'priority'    => 1,
            'title'       => __( 'General', 'bootframe-core' ),

        ) );

//add section: logo
        $wp_customize->add_section('smartlib_section_logo', array(
            'title' => __('Logo & favicon', 'bootframe-core'),
            'panel' => 'smartlib_panel_general_settings',
            'priority' => 20,
        ));



        $wp_customize->add_section('smartlib_section_preloader', array(
            'title' => __('Loading Animation', 'bootframe-core'),
            'panel' => 'smartlib_panel_general_settings',
            'priority' => 30,
        ));

        $wp_customize->add_section('section_smartlib_gallery_default', array(
            'title' => __('Gallery', 'bootframe-core'),
            'priority' => 31,
            'panel' => 'smartlib_panel_general_settings',
        ));
        //add section: custom code

        $wp_customize->add_section('section_smartlib_custom_code', array(
            'title' => __('Custom Code', 'bootframe-core'),
            'priority' => 80,
            'panel' => 'smartlib_panel_general_settings',
        ));




        /*Put default sections in general panel*/
        $wp_customize->get_section('colors')->panel = 'smartlib_panel_general_settings';
        $wp_customize->get_section('title_tagline')->panel = 'smartlib_panel_general_settings';
        $wp_customize->get_section('header_image')->panel = 'smartlib_panel_general_settings';
        $wp_customize->get_section('background_image')->panel = 'smartlib_panel_general_settings';


        //add section: home page
        $wp_customize->add_section('smartlib_section_homepage', array(
            'title' => __('Home Page', 'bootframe-core'),

            'priority' => 20,
        ));


        //add section: pagination
        $wp_customize->add_section('section_pagination_posts', array(
            'title' => __('Pagination', 'bootframe-core'),
            'priority' => 90,
        ));




        $wp_customize->add_section('smartlib_pages_settings', array(
            'title' => __('Pages Settings', 'bootframe-core'),
            'priority' => 80,
        ));

        $wp_customize->add_section('smartlib_blog_settings', array(
            'title' => __('Blog Settings', 'bootframe-core'),
            'priority' => 80,
        ));

        /*ADD PREMIUM SECTIONS*/

        //add section: layout
        $wp_customize->add_section('smartlib_layout', array(
            'title' => __('Layout', 'bootframe-core'),
            'priority' => 40,
        ));



        /*Fonts & Text Colors*/

        $wp_customize->add_panel( 'smartlib_panel_font_and_color', array(
            'priority'    => 10,
            'title'       => __( 'Fonts & Text Colors', 'bootframe-core' ),

        ) );

        $wp_customize->add_section('smartlib_general_text_styles', array(
            'title' => __('General Text Settings', 'bootframe-core'),
            'priority' => 2,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_header1_styles', array(
            'title' => __('H1 Style', 'bootframe-core'),
            'priority' => 2,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_header2_styles', array(
            'title' => __('H2 Style', 'bootframe-core'),
            'priority' => 2,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_header3_styles', array(
            'title' => __('H3 Style', 'bootframe-core'),
            'priority' => 3,
            'panel'          => 'smartlib_panel_font_and_color',
        ));
        $wp_customize->add_section('smartlib_header4_styles', array(
            'title' => __('H4 Style', 'bootframe-core'),
            'priority' => 4,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_header5_styles', array(
            'title' => __('H5 Style', 'bootframe-core'),
            'priority' => 5,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_header6_styles', array(
            'title' => __('H6 Style', 'bootframe-core'),
            'priority' => 6,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_section('smartlib_link_styles', array(
            'title' => __('Links Style', 'bootframe-core'),
            'priority' => 7,
            'panel'          => 'smartlib_panel_font_and_color',
        ));

        $wp_customize->add_panel( 'smartlib_panel_default_buttons', array(
            'priority'    => 15,
            'title'       => __( 'Buttons Settings', 'bootframe-core' ),

        ) );

        $wp_customize->add_section('smartlib_section_default_button', array(
            'title' => __('Default Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 1,
        ));

        $wp_customize->add_section('smartlib_section_primary_button', array(
            'title' => __('Primary Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 2,
        ));

        $wp_customize->add_section('smartlib_section_success_button', array(
            'title' => __('Success Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 3,
        ));

        $wp_customize->add_section('smartlib_section_info_button', array(
            'title' => __('Info Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 4,
        ));

        $wp_customize->add_section('smartlib_section_warning_button', array(
            'title' => __('Warning Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 5,
        ));

        $wp_customize->add_section('smartlib_section_danger_button', array(
            'title' => __('Danger Button', 'bootframe-core'),
            'panel' => 'smartlib_panel_default_buttons',
            'priority' => 6,
        ));


        /*Navbar Panels and Sections*/

            $wp_customize->add_panel( 'smartlib_panel_navbar', array(
                'priority'    => 20,
                'title'       => __( 'Navbar Area', 'bootframe-core' ),

            ) );

        /*Top Bar*/
        $wp_customize->add_section('smartlib_topbar_section', array(
            'title' => __('Top Bar Section', 'bootframe-core'),
            'priority' => 10,
            'panel'          => 'smartlib_panel_navbar',
        ));

        $wp_customize->add_section('smartlib_header_section', array(
            'title' => __('Main Navbar Style', 'bootframe-core'),
            'priority' => 20,
            'panel'          => 'smartlib_panel_navbar',
        ));

        $wp_customize->add_section('smartlib_main_menu_section', array(
            'title' => __('Main Menu', 'bootframe-core'),
            'priority' => 20,
            'panel'          => 'smartlib_panel_navbar',
        ));

        /*Footer*/

        $wp_customize->add_section('smartlib_footer_section', array(
            'title' => __('Footer Section', 'bootframe-core'),
            'priority' => 21,
        ));
    }

    /*
     * Add native settings and controls
     */
    private function add_settings_controls($wp_customize)
    {



        $wp_customize->add_setting('smartlib_text_header', array(

            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',

        ));


        /*top header info*/
        $wp_customize->add_control('smartlib_text_header', array(
            'label' => __('Header info', 'bootframe-core'),
            'section' => 'smartlib_topbar_section',
            'settings' => 'smartlib_text_header',
            'type' => 'text',

        ));

        /*footer copyright info*/

        $wp_customize->add_setting('smartlib_text_footer', array(

            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('smartlib_text_footer', array(
            'label' => __('Copyright text', 'bootframe-core'),
            'section' => 'smartlib_footer_section',
            'settings' => 'smartlib_text_footer',
            'type' => 'text',

        ));




        //add setting breadcrumb_separator

        $wp_customize->add_setting('breadcrumb_separator', array(

            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control('breadcrumb_separator', array(
            'label' => __('Separator', 'bootframe-core'),
            'section' => 'section_smartlib_breadcrumb',
            'settings' => 'breadcrumb_separator',
            'type' => 'text',

        ));

        /*Primary theme color*/









        /*LOGO*/
        $wp_customize->add_setting('smartlib_logo', array(


            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));


        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'smartlib_logo', array(
            'label' => __('Upload', 'bootframe-core'),
            'section' => 'smartlib_section_logo',
            'settings' => 'smartlib_logo',
        )));

        /* Favicon */

        $wp_customize->add_setting('smartlib_favicon', array(


            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));


        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'smartlib_favicon', array(
            'label' => __('Upload favicon', 'bootframe-core'),
            'section' => 'smartlib_section_logo',
            'settings' => 'smartlib_favicon',
            'active_callback' => array('__SMARTLIB_HELPERS', 'conditional_has_site_icon'),
        )));


        /*Home Page*/
        $wp_customize->add_setting('smartlib_homepage_version', array(
            'default' => 1,
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));


        $wp_customize->add_setting('smartlib_homepage_header', array(
            'default' => 1,
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control('smartlib_homepage_header', array(
            'settings' => 'smartlib_homepage_header',
            'label' => __('Home Page Header:', 'bootframe-core'),
            'section' => 'static_front_page',
            'active_callback' => 'is_home',
            'type' => 'radio',
            'priority' => 12,
            'choices' => array(
                '1' => __('Show header', 'bootframe-core'),
                '2' => __('Hide Header', 'bootframe-core'),


            )

        ));

        /*add fluid header row option*/

        $wp_customize->add_setting('smartlib_fluid_header_frontpage', array(
            'default' => 1,
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control('smartlib_fluid_header_frontpage', array(
            'settings' => 'smartlib_fluid_header_frontpage',
            'label' => __('Fluid header:', 'bootframe-core'),
            'section' => 'static_front_page',
            'type' => 'radio',
            'priority' => 15,
            'choices' => array(
                '1' => __('No', 'bootframe-core'),
                '2' => __('Yes', 'bootframe-core'),


            )

        ));

        $wp_customize->add_setting('smartlib_homepage_slider_shortcode', array(

            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control('smartlib_homepage_slider_shortcode', array(
            'label' => __('Slider Shortcode', 'bootframe-core'),
            'section' => 'static_front_page',
            'settings' => 'smartlib_homepage_slider_shortcode',

            'type' => 'text',
            'priority' => 11,
        ));




    }

    /*
     * Add Custom controls to the sections
     */
    function smartlib_kirki_controls($controls)
    {


            foreach(self::$controls_array as $row){

                $controls[] = $row;

            }


        return $controls;
    }


    function smartlib_add_premium_info($wp_customize){

        foreach(self::$default_config->premium_sections_array as $section){

            $wp_customize->add_setting( $section .'_info', array(
                'default'    => '',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( new Smartlib_Customizer_Info_Field( $wp_customize, $section .'_info', array(
                'label'      => __( 'Premium Version', 'bootframe-core'),
                'section'    => $section,
                'capability' => 'edit_theme_options',
                'settings'   => $section .'_info'

            ) ) );

        }


    }



    /**
     * Adds smartlib safe fonts to array
     *
     * @param $merged_array - kirki fonts array
     *
     * @return array
     */
    function smartlib_safe_fonts($merged_array)
    {

        $all_fonts = array_merge(self::$default_config->smartlib_safe_fonts, $merged_array);

        return $all_fonts;
    }

    /**
     * Live preview javascript
     *
     * @since  project 1.0
     * @return void
     */
    public function customize_preview_js()
    {

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '.dev' : '';

        wp_register_script(
            self::$theme_key . '-customizer',
            get_template_directory_uri() . '/js/theme-customizer' . $suffix . '.js',
            array('customize-preview'),
            FALSE,
            TRUE
        );

        wp_enqueue_script(self::$theme_key . '-customizer');
    }

    /**
     *
     * Context method for slider option
     *
     * @param $control
     *
     * @return bool
     */
    public function conditional_slider_shortcode($control)
    {

        $option = $control->manager->get_setting('smartlib_homepage_slider');
        return $option->value() == '2';

    }

    public function conditional_homepage_slider($control)
    {

        $option = $control->manager->get_setting('smartlib_homepage_version');

        if ($option->value() == '2' && is_home()) {
            return true;
        } else {
            return false;
        }


    }



    /**
     * Generate social links controls
     *
     * @param $controls
     * @return array
     */
    protected function generate_social_options($controls)
    {

        $config_media_options = self::$default_config->supported_social_media;
        $i = 1;
        foreach ($config_media_options as $key => $row) {
            $i++;
            $controls[] = array(
                'type' => 'text',
                'setting' => 'smartlib_socialmedia_link_' . $key,
                'label' => $row,
                'section' => 'smartlib_social_links',

                'priority' => $i);

        };

       return $controls;
    }





}




/**
 * Customize for textarea, extend the WP customizer
 *
 */

if (class_exists('WP_Customize_Control'))
{
    class Smartlib_Customizer_Info_Field extends WP_Customize_Control {
        public $type = 'extendinfo';

        public function render_content() {
            ?>
            <div class="smartlib-form-proversion-info-outer">
                <div class="smartlib-form-proversion-info-inner"><a
                        href="http://rocksite.pro/bootframe/"
                        target="_blank"
                        class="bootframe-proversion-link" style="font-weight: bold; padding-top: 50px; font-size: 15px;"><?php _e('More available in pro version &#187;', 'bootframe-core');?></a>
                </div>
                <?php

                if(file_exists(SMART_ADMIN_DIRECTORY. '/css/img/'.$this->id .'.png')){
                ?>
                <div class="smartlib-color-readonly-image"><img src="<?php echo SMART_ADMIN_DIRECTORY_URI. '/css/img/'.$this->id ?>.png" alt="<?php _e('Available in pro version', 'bootframe-core') ?>" /></div>
                <?php
                }
                ?>
            </div>
        <?php
        }
    }
}









