<?php

/*
 * Load TGM Plugin
 */

require_once locate_template('/smart-lib/vendor/tgm/class-tgm-plugin-activation.php');

/**
 * Redirect after theme activation
 */

global $pagenow;



/*
 * Register smartlib activation function
 */
add_action('admin_menu', 'smartlib_theme_activation_options', 999);

/*
 * Create the function that build menu
 */

function smartlib_theme_activation_options()
{
    add_theme_page(__('Bootframe Pro', 'bootframe-core'), __('Bootframe Pro', 'bootframe-core'), 'manage_options', 'bootframe_activation', 'smartlib_activation_display');
    remove_submenu_page('themes.php', 'tgmpa-install-plugins' );
}

/*
 * Create a function that displays the contents of the options page
 */

function smartlib_activation_display()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'bootframe-core'));
    }





    ?>
    <div class="wrap">
        <h2><?php _e('BootFrame Premium', 'bootframe-core') ?></h2>


        <div class="welcome-panel">
            <h1 style="font-size: 36px; line-height: 1.2; max-width: 1200px"><?php _e('Need more features, extensive documentation and theme support? Learn more about BootFrame Premium!', 'bootframe-core') ?></h1>

            <p class="about-description" style="padding-top: 20px"><a href="https://creativemarket.com/netbiel/341968-BootFrame-WordPress-theme" target="_blank">BootFrame Premium</a> <?php _e('adds exciting new customization features to the Customizer and other powerful customization tools like shortcodes or layout options.', 'bootframe-core') ?></p>

             <div id="col-container" style="padding-top: 50px;">
                <div id="col-left" style="float: left">
                    <div class="col-wrap">
                        <h2 style=""><?php _e('Listed below are only the extras that the paid version brings:', 'bootframe-core'); ?></h2>
                        <ul style="list-style-type:disc; padding: 10px 20px;margin-left: 20px">
                            <li><?php _e('More theme options', 'bootframe-core'); ?></li>
                            <li><?php _e('More custom widgets', 'bootframe-core'); ?></li>
                            <li><?php _e('Single page configuration panel', 'bootframe-core'); ?></li>
                            <li><?php _e('Advanced Slider Support', 'bootframe-core'); ?></li>
                            <li><?php _e('Parallax sections support', 'bootframe-core'); ?></li>
                            <li><?php _e('WPML and Polylang Support', 'bootframe-core'); ?></li>
                            <li><?php _e('Advanced Custom Post Types: Portfolio, Testimonials', 'bootframe-core'); ?></li>
                            <li><?php _e('LESS files included', 'bootframe-core'); ?></li>
                            <li><?php _e('Grunt configuration file included', 'bootframe-core'); ?></li>
                            <li><?php _e('Extensive documentation', 'bootframe-core'); ?></li>
                            <li><?php _e('One Click Demo Install', 'bootframe-core'); ?></li>
                            <li><?php _e('Incredible Support', 'bootframe-core'); ?></li>
                            <li><?php _e('and much more...', 'bootframe-core'); ?></li>
                        </ul>
                    </div>
                </div>
                <div id="col-right">
                    <div class="col-wrap">
                       <img src="<?php echo get_template_directory_uri() ?>/assets/img/preview-presentation-3.jpg" alt="Bootframe Pro" style="max-width: 100%;margin-top: 60px" />
                    </div>
                </div>
            </div>
            <p><a href="https://creativemarket.com/netbiel/341968-BootFrame-WordPress-theme" class="button button-primary button-hero" target="_blank"><?php _e('More Info', 'bootframe-core') ?> &raquo;</a></p></p>

        </div>

    </div>
<?php }


/**
 * TGMPA PLugin Register Function
 */
function smartlib_activation_setup()
{

    add_action('tgmpa_register', 'smartlib_theme_register_required_plugins');
}

add_action('after_setup_theme', 'smartlib_activation_setup');


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to bootframe_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into bootframe_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function smartlib_theme_register_required_plugins()
{

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name' => 'Page Builder by SiteOrigin', // The plugin name.
            'slug' => 'siteorigin-panels', // The plugin slug (typically the folder name).
            'source' => '', // The plugin source.
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => 'https://downloads.wordpress.org/plugin/siteorigin-panels.2.2.zip', // If set, overrides default API URL and points to an external URL.
        ),

        array(
            'name' => 'Smartlib Tools', // The plugin name.
            'slug' => 'smartlib-tools', // The plugin slug (typically the folder name).
            'source' => '', // The plugin source.
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => 'https://downloads.wordpress.org/plugin/smartlib-tools.zip', // If set, overrides default API URL and points to an external URL.
        ),

        array(
            'name' => 'Meta Slider', // The plugin name.
            'slug' => 'ml-slider', // The plugin slug (typically the folder name).
            'source' => '', // The plugin source.
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => 'https://downloads.wordpress.org/plugin/ml-slider.3.3.5.zip', // If set, overrides default API URL and points to an external URL.
        ),

        array(
            'name' => 'Shortcodes Ultimate', // The plugin name.
            'slug' => 'shortcodes-ultimate', // The plugin slug (typically the folder name).
            'source' => '', // The plugin source.
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => 'https://downloads.wordpress.org/plugin/shortcodes-ultimate.zip', // If set, overrides default API URL and points to an external URL.
        ),


        array(
            'name' => 'Contact Form 7', // The plugin name.
            'slug' => 'contact-form-7', // The plugin slug (typically the folder name).
            'source' => '', // The plugin source.
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => 'https://downloads.wordpress.org/plugin/contact-form-7.4.3.zip', // If set, overrides default API URL and points to an external URL.
        ),




    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => __('Install Required Plugins', 'bootframe-core'),
            'menu_title' => __('Install Plugins', 'bootframe-core'),
            'installing' => __('Installing Plugin: %s', 'bootframe-core'), // %s = plugin name.
            'oops' => __('Something went wrong with the plugin API.', 'bootframe-core'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bootframe-core'), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bootframe-core'), // %1$s = plugin name(s).
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'bootframe-core'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'bootframe-core'),
            'return' => __('Return to Required Plugins Installer', 'bootframe-core'),
            'plugin_activated' => __('Plugin activated successfully.', 'bootframe-core'),
            'complete' => __('All plugins installed and activated successfully. %s', 'bootframe-core'), // %s = dashboard link.
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa($plugins, $config);

}


/**
 *
 * Check if display install plugins menu
 *
 * @return bool
 */
function smartlib_check_if_install_plugin_exists()
{
    if (isset($GLOBALS['submenu'])) {
        foreach ($GLOBALS['submenu'] as $level1) {
            foreach ($level1 as $level2) {
                if (in_array('tgmpa-install-plugins', $level2)) {
                    return true;
                }
            }
        }
    }

    return false;
}


?>