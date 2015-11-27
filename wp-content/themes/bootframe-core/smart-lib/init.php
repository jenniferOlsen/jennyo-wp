<?php

/*DEFINITIONS*/
define('SMART_LIB_DIRECTORY', '/smart-lib/');
define('SMART_TEMPLATE_DIRECTORY', get_template_directory());
define('SMART_TEMPLATE_DIRECTORY_URI', get_template_directory_uri());
define('SMART_STYLESHEET_DIRECTORY', get_stylesheet_directory_uri());
define('SMART_ADMIN_DIRECTORY_URI', SMART_TEMPLATE_DIRECTORY_URI.'/admin');
define('SMART_KIRKI_URI', SMART_TEMPLATE_DIRECTORY_URI .SMART_LIB_DIRECTORY. 'vendor/kirki/');
define('SMART_ADMIN_DIRECTORY', SMART_TEMPLATE_DIRECTORY.'/admin');

/*Meta-box plugin integration*/
define( 'RWMB_URL', SMART_TEMPLATE_DIRECTORY_URI. '/smart-lib/vendor/meta-box/' );
define( 'RWMB_DIR', SMART_TEMPLATE_DIRECTORY. '/smart-lib/vendor/meta-box/' );



class Smartlib_Init{


	public $default_config;

	/*list of widgets from class custom widgets file*/

	public $project_widgets = array(
		'Smart_Widget_Recent_Posts',
		'Smart_Widget_One_Author',
		'Smart_Widget_Social_Icons',
		'Smart_Widget_Video',
		'Smart_Widget_Recent_Videos',
		'Smart_Widget_Search',
		'Smart_Widget_Recent_Galleries',
		'Smart_Extend_Content',
		'Smart_Widget_Contact_Form',
		'Smart_Widget_Section_Header',
		'Smart_Widget_Portfolio_Items',
		'Smart_Display_Page_Content',
		'Smart_Counter_Box',
		'Smart_Team_Box',
		'Smart_Widget_Testimonial_Items',
		'Smart_Widget_Last_Articles_Columns',
		'Smart_Simple_Call_To_Action'
	);


	function __construct(){

		/* load all required php files*/
		$this->requires();

		/*Load Default Config*/

		$this->default_config = Smartlib_Config::getInstance();

		//pass admin object to the constructor
		$this->customizer_project = new Smartlib_Customizer();

		$this->customizer_style = Smartlib_Custom_Styles::getInstance($this->default_config);

		//initialize smartlib actions & filters

		new Smartlib_Filters($this->default_config);
		new Smartlib_Actions($this->default_config);

		new Smartlib_Features($this->default_config);


		//Setup the Theme Customizer settings and controls
		add_action( 'customize_register', array( $this->customizer_project, 'register' ) );

		/*Load all scripts*/

		add_action( 'wp_enqueue_scripts',   array( $this, 'smartlib_scripts' ), 1 );

		/*Load admin scripts*/
		add_action( 'admin_head', array( $this, 'admin_print_css_js' ) );

		add_filter( 'kirki/config',         array( $this, 'kirki_customizer_config' ) );

		add_action('wp_head',  array( $this,'header_scripts'),  1000); //add google analytics code - at the very end

		//add customizer fonts
		add_action('wp_head',  array( $this->customizer_style,'header_fonts_output'), 2);

		add_action( 'wp_enqueue_scripts', array( $this->customizer_style,'header_css_output'), 1000);

		/*
		 * Register all widgets
		 */
		add_action( 'widgets_init', array($this, 'register_theme_widgets'));


		//add custom code - header
		add_action('wp_head', array($this, 'custom_code_header'));
		//add custom code - footer
		add_action('wp_footer', array($this, 'custom_code_footer'));

		//add favicon
		add_action ( 'wp_head', array($this,'display_favicon') );



	}

	public function requires(){

		$files = array(
			'smart-lib/class-config.php',
			'smart-lib/classes/class-bootstrap-menu-walker.php',
			'smart-lib/classes/class-custom-widgets.php',
			'smart-lib/classes/class-features.php',
			'smart-lib/classes/class-tgm-plugin-activation.php',
			'smart-lib/vendor/kirki/kirki.php',
			'smart-lib/classes/smartlib-customizer.php',
			'smart-lib/classes/class-smartlib-actions.php',
			'smart-lib/classes/class-smartlib-filters.php',
			'smart-lib/classes/class-smartlib-layout-helpers.php',
			'smart-lib/classes/class-helpers.php',
			'smart-lib/class-customizer-options.php',
			'smart-lib/template-tags.php',
			'smart-lib/classes/class-smartlib-custom-styles.php',
			'smart-lib/integrations/page-builder-integration.php',//page builder integration




		);
      
		foreach ( $files as $file ) {
			locate_template( $file , true);
		}
	}

	function smartlib_scripts() {

		/*register bootstrap*/

		wp_register_style('smartlib_bootstrap',  get_template_directory_uri() . '/assets/css/bootstrap.css', false);
		wp_enqueue_style('smartlib_bootstrap');






		/*register awesome css*/
		wp_register_style('smartlib_font_awesome',  get_template_directory_uri() . '/assets/vendor/font-awesome/css/font-awesome.min.css', false);
		wp_enqueue_style('smartlib_font_awesome');

		wp_register_style('smartlib_prettyphoto',  get_template_directory_uri() . '/assets/vendor/prettyPhoto/css/prettyPhoto.css', false);
		wp_enqueue_style('smartlib_prettyphoto');

		/*ad main stylesheet*/
		wp_register_style('smartlib_main',  get_stylesheet_uri(), false);
		wp_enqueue_style('smartlib_main');


    /*flexislider*/
		wp_register_style('smartlib_flexislider',  get_template_directory_uri() . '/assets/vendor/flexslider/flexslider.css', false);
		wp_enqueue_style('smartlib_flexislider');

		/*animate css*/
		wp_register_style('smartlib_animate',  get_template_directory_uri() . '/assets/css/animate.css', false);
		wp_enqueue_style('smartlib_animate');

		if (is_single() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

		/*flexislider scripts*/
		wp_register_script('smartlib-flexislider', get_template_directory_uri() . '/assets/vendor/flexslider/jquery.flexslider-min.js', array('jquery'), null, false);
		wp_enqueue_script('smartlib-flexislider');

		/*prettyPhoto scripts*/
		wp_register_script('smartlib-prettyphoto', get_template_directory_uri() . '/assets/vendor/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), null, false);
		wp_enqueue_script('smartlib-prettyphoto');

		/*bootstrap*/
		wp_register_script('smartlib-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), null, true);
		wp_enqueue_script('smartlib-bootstrap');

		/*animated header*/


		wp_register_script('smartlib-classie-header', get_template_directory_uri() . '/assets/js/classie.js', array('jquery'), null, true);
		wp_enqueue_script('smartlib-classie-header');

		wp_register_script('smartlib-animated-header', get_template_directory_uri() . '/assets/js/cbpAnimatedHeader.min.js', array('jquery', 'smartlib-classie-header'), null, true);
		wp_enqueue_script('smartlib-animated-header');

		/*modernizr*/
		wp_register_script('smartlib-modernizr', get_template_directory_uri() . '/assets/vendor/modernizr.custom.09812.js', array('jquery'), null, true);
		wp_enqueue_script('smartlib-modernizr');

		/*jquery.waypoints.min.js*/

		wp_register_script('smartlib-waypoints', get_template_directory_uri() . '/assets/js/jquery.waypoints.min.js', array('jquery'), null, true);
		wp_enqueue_script('smartlib-waypoints');

		/*counter */

		wp_register_script('smartlib-counter', get_template_directory_uri() . '/assets/js/jquery.countTo.js', array('jquery'), null, true);
		wp_enqueue_script('smartlib-counter');

		wp_register_script('smartlib-shuffle', get_template_directory_uri() . '/assets/vendor/jquery.shuffle.js', array(), null, true);
		wp_enqueue_script('smartlib-shuffle');

		wp_register_script('smartlib-main', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);

		wp_enqueue_script('smartlib-main');

	}

	function get_default_config(){
		return $this->default_config;
	}

	/**
	 * The configuration options for Kirki Customizer
	 */
	function kirki_customizer_config() {



		$args = array(



			// If Kirki is embedded in your theme, then you can use this line to specify its location.
			// This will be used to properly enqueue the necessary stylesheets and scripts.
			// If you are using kirki as a plugin then please delete this line.
			'url_path'     =>SMART_KIRKI_URI,

			// If you want to take advantage of the backround control's 'output',
			// then you'll have to specify the ID of your stylesheet here.
			// The "ID" of your stylesheet is its "handle" on the wp_enqueue_style() function.
			// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
			'stylesheet_id' => 'bstarter',

		);

		return $args;

	}


	function header_scripts(){

		//google analitics script
		echo get_theme_mod( 'google_analytics');
	}

	/*
	 * External admin scripts
	 */
	function admin_print_css_js(){
		wp_enqueue_media();
		wp_enqueue_script( 'smartlib-admin-js',get_template_directory_uri() . '/admin/js/admin-scripts.js', array( 'jquery', 'plupload-all' ), '1', true );
		wp_enqueue_style( 'smartlib-admin-css',get_template_directory_uri() . '/admin/css/css-admin-mod.css');
	}

	/*
	 * Register widgets
	 */
	public function register_theme_widgets(){

		if(count($this->project_widgets)>0){
			foreach($this->project_widgets as $widget_class){
				if(class_exists($widget_class) ){
					register_widget($widget_class);
				}
			}
		}
	}

	/**
	 * Display favicon
	 */
	public function display_favicon() {
		$favico = get_theme_mod( 'smartlib_favicon', '' );

		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

			if ( ! empty( $favico ) ) {
				$extension = substr( $favico, strrpos( $favico, '.' )+1, 3 );
				?>
				<link rel="icon" type="image/<?php echo $extension ?>" href="<?php echo $favico ?>" />
			<?php

			}

		}
	}


	/**
	 * Custom code header action
	 */

	public function custom_code_header(){

		$code = get_theme_mod('custom_code_header', '');

		if(strlen($code)>0){

			echo "\n".$code ."\n";

		}

	}

	/**
	 * Custom code footer action
	 */

	public function custom_code_footer(){

		$code = get_theme_mod('custom_code_footer', '');

		if(strlen($code)>0){

			echo "\n".$code ."\n";

		}

	}

}