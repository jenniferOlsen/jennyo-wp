<?php


class Smartlib_Filters {

	static $instance;
	public $default_config;

	public function __construct( $conObj ) {
		self::$instance =& $this;

		$this->default_config = $conObj;

		/*FILTERS*/
		add_filter( 'smartlib_header_fixed_class', array( $this, 'smartlib_header_fixed_class' ), 10 );

		add_filter( 'smartlib_sidebar_layout_class', array( $this, 'smartlib_sidebar_layout_class' ), 10, 2 );
		add_filter( 'smartlib_content_layout_class', array( $this, 'smartlib_content_layout_class' ), 10, 2 );

		add_filter( 'smartlib_before_sidebar', array( $this, 'smartlib_before_sidebar' ), 10,2 );
		add_filter( 'smartlib_get_awesome_ico', array( $this, 'smartlib_get_awesome_ico' ), 10,2 );

		add_filter( 'smartlib_after_sidebar', array( $this, 'smartlib_after_sidebar' ), 10,2 );
		add_filter( 'smartlib_before_logo', array( $this, 'smartlib_before_logo' ), 10 );
		add_filter( 'smartlib_after_logo', array( $this, 'smartlib_after_logo' ), 10 );


        //smartlib aligment class
		add_filter( 'smartlib_algin_text', array( $this, 'smartlib_algin_text' ), 10, 2 );



		//change more link button
		add_filter( 'the_content_more_link', array( $this, 'smartlib_content_more' ), 10 );

		add_filter( 'smartlib_main_navigation_class', array( $this, 'smartlib_main_navigation_class' ), 10, 2 );

		//subtitle
		//add_filter( 'the_title', array( $this,'smartlib_add_subtitle'), 10 );

		//Body class
		add_filter('body_class',array( $this,'smartlib_body_class_modyficator'), 2);

		//conditional class
		add_filter('smartlib_conditional_class',array( $this,'smartlib_conditional_class'), 3, 3);

		/*
		 * Modify WordPress Native Filters
		 */

		/* Widgets filters */

		add_filter( 'smartlib_widget_before_title', array( $this, 'smartlib_widget_before_title' ), 10,2 );
		add_filter( 'smartlib_widget_after_title', array( $this, 'smartlib_widget_after_title' ), 10,2 );

		/*Pagination next/prev filters*/
		add_filter('next_posts_link_attributes', array( $this,'smartlib_prevnext_link_attributes'));
		add_filter('previous_posts_link_attributes', array( $this,'smartlib_prevnext_link_attributes'));

		/*Portfolio*/
		add_filter('smartlib_portfolio_filter_string', array( $this,'smartlib_portfolio_filter_string'));

		/*plugini integration filters*/
		add_filter( 'smartlib_get_theme_config', array( $this, 'smartlib_get_theme_config' ), 10 );

		/*add rel attribute*/
		add_filter('wp_get_attachment_link', array( $this,'smartlib_add_rel_attribute'));

		/*page header class*/

		add_filter('smartlib_page_header_class', array( $this,'smartlib_page_header_class'),10, 4 );



	}

	/**
	Retrieves project_fixed_top bar option and get fixed class
	 */
	public function smartlib_header_fixed_class() {

		$fixed = get_theme_mod( 'project_fixed_topbar' );
		echo $fixed == '1' ? ' smartlib-fixed-top-bar' : '';
	}

	/**
	 * Get smartlib sidebar class
	 *
	 * @param string $default_class - default class
	 * @param string $config_class  - pass param from config array
	 *
	 * @return string
	 */

	public function smartlib_sidebar_layout_class( $default_class = '', $config_class = '' ) {
		if ( strlen( $config_class ) > 0 ) {
			return $config_class;
		}
		else {
			return $default_class;
		}
	}

	/**
	 *
	 * Return default open tag container
	 * @param        $default_container
	 * @param string $type
	 *
	 * @return mixed
	 */
	public function smartlib_before_sidebar($default_container, $type=''){

		$assign_context_sidebar = $this->default_config->assign_context_sidebar;

		if(empty($type)){

			return $default_container;
		}

		if(isset($assign_context_sidebar[$type])){

			return $assign_context_sidebar[$type][0];//return closed tax
		}else{

			return $default_container;
		}


	}

	/**
	 *
	 * Return default close tag container
	 * @param        $default_container
	 * @param string $type
	 *
	 * @return mixed
	 */
	public function smartlib_after_sidebar($default_container, $type=''){

		$assign_context_sidebar = $this->default_config->assign_context_sidebar;

		if(empty($type)){
			return $default_container;
		}

		if(isset($assign_context_sidebar[$type])){

			return $assign_context_sidebar[$type][2];//return closed tax
		}else{

			return $default_container;
		}


	}

	public function smartlib_before_logo($tag){
		if ( is_front_page() ) {
			$header_tag = '<h1 class="smartlib-logo-header" itemprop="headline">';
		}
		else {
			$header_tag = $tag;
		}

		return $header_tag;
	}

	public function smartlib_after_logo($tag){
		if ( is_front_page() ) {
			$header_tag = '</h1>';
		}
		else {
			$header_tag = $tag;
		}

		return $header_tag;
	}


	/**
	 * Return Awesome Ico class string
	 * @param string $default_ico
	 * @param string $key_class
	 *
	 * @return mixed|string|void
	 */
	function smartlib_get_awesome_ico($default_ico='', $key_class=''){
		if ( $key_class != '' ) {

			$class_name = $this->get_awesome_icon_class( $key_class );

			$return_string = $class_name;
		}
		else {
			$return_string = $default_ico;
		}

		return  $return_string;
	}
	/**
	Return value form  $this->icon_awesome_translate_class
	 */
	public function get_awesome_icon_class( $key ) {

		$icon_awesome_translate_class = $this->default_config->icon_awesome_translate_class;

		if ( isset( $icon_awesome_translate_class[$key] ) ) {
			$icon_class =  $icon_awesome_translate_class[$key];
		}
		else {
			$icon_class =  $icon_awesome_translate_class['default_icon'];
		}

		return apply_filters('smartlib_icon_class', $icon_class);
	}

	/**
	 * Get layout class based on configuration
	 * @param string $default_class
	 * @param string $type
	 *
	 * @return mixed
	 */
	public function smartlib_content_layout_class( $default_class = '', $type = 'default' ) {
		global $post;
		$option = get_theme_mod( 'smartlib_layout_' . $type );


		//get category option
		$cat = get_query_var('cat');

		$cat_extra_data = get_option( 'category_' . $cat );

		$category_variant = isset($cat_extra_data['smartlib_layout_category'])? (int)$cat_extra_data['smartlib_layout_category']:0;



		if(isset($post) && is_singular('page')){

			$option = get_post_meta( $post->ID, 'smartlib_layout_' . $type, true );

		}

		if ( $option  =='' ) {

			$option = get_theme_mod( 'smartlib_layout_default', 1 );

		}

		//if category option = 1 force no sidebar

		if($category_variant ==1){
			$option = 0;
		}

		return $this->smartlib_filter_config_class( $default_class, $option, 'content' );

	}

	/**
	 * Return layout class of component
	 * @param $default_class
	 * @param $option    - theme_mod option
	 * @param $component - component: sidebar, content
	 *
	 * @return mixed
	 */
	private function smartlib_filter_config_class( $default_class, $option, $component ) {
		$layout_class_array = $this->default_config->layout_class_array;
		$index              = (int) $option;
		if ( isset( $layout_class_array[$index] ) && strlen( $layout_class_array[$index][$component] ) > 0 ) {
			return $layout_class_array[$index][$component];
		}
		else {
			return $default_class;
		}

	}

	public function smartlib_content_more(){
		$link = get_permalink('');
		$new_link = '<p class="text-right"><a class="btn btn-primary more-link" href="' . esc_url($link) . '">'.__('Continue reading', 'bootframe-core').'  <i class="'.apply_filters('smartlib_get_awesome_ico', 'fa fa-share', 'more-link') .'"></i></a></p>';

		return $new_link;
	}

	public function smartlib_widget_before_title($before_title, $instance){

		if(isset($instance['panels_info'])){
			return '<header class="smartlib-widget-header panel-heading">'.$before_title;
		}else{
			return $before_title;
		}
	}

	public function smartlib_widget_after_title($after_title, $instance){

		if(isset($instance['panels_info'])){
			return $after_title.'</header>';
		}else{
			return $after_title;
		}
	}

	public function smartlib_main_navigation_class($default_string, $type='default'){
		$classes = $default_string;


		$option_search = (int)get_theme_mod( 'smartlib_show_search_in_navbar_' . 'default', 2 );
        if($option_search==2){
			$classes .= ' smartlib-navbar-with-search';
		}

		$option_fixed = (int)get_theme_mod( 'smartlib_fixed_navbar_' . 'default', 2 );
		if($option_fixed==2){
			$classes .= ' navbar-fixed-top';
		}

		$option_in_grid = get_theme_mod('smartlib_ingrid_navbar_'.$type);

		if($option_in_grid=='2'){
			$classes .= ' smartlib-nabar-in-grid';
		}


		return $classes;
	}

	/*
	 * Add single page subtitle

	function smartlib_add_subtitle($title){
		global $post;
		global $wp_query;

		$title_content =$title;

		if(is_singular( 'page' )&& in_the_loop()){

			$subtitle = get_post_meta( $post->ID, 'smartlib_page_subtitle', true );

			if(strlen($subtitle))
			$title_content .='<small>' .$subtitle .'</small>';
		}

		return $title_content;
	}
*/

	/**
	 * Change Body Class
	 * @param $classes
	 * @param string $type
	 * @return array
	 */
	function smartlib_body_class_modyficator($classes, $type='default'){
 		global $post;

		$meta_option = '';

		$top_bar_option = (int) get_theme_mod('smartlib_show_top_bar_'. $type, 1);

		if(isset($post->ID)){
			$meta_option = get_post_meta($post->ID, 'smartlib_show_top_bar_page' , true);
		}


		if(strlen($meta_option)>0){
			$top_bar_option = (int) $meta_option;
		}

		$navbar_over_content = get_theme_mod('smartlib_navbar_over_content_'. $type, 0);


		if($top_bar_option==1){
			$classes[] = 'smartlib-body-has-topbar';//if navigation is fixed
		}

		if($navbar_over_content=='1'){
			$classes[] = 'smartlib-body-navbar-over-content';//if navigation is fixed
		}

		$navigation_option = get_theme_mod('smartlib_fixed_navbar_'. $type, 2);
		if($navigation_option=='2'){
			$classes[] = 'smartlib-body-navigation-fixed';//if navigation is fixed
		}else{
			$classes[] = 'smartlib-body-navigation-static';//if navigation is fixed
		}

		/*check local page settings*/

		if(isset($post->ID)){


			$page_navigation_option = get_post_meta( $post->ID, 'smartlib_navbar_over_content', true );


			if($page_navigation_option=='1'){
			$classes[] = 'smartlib-body-navbar-over-content';//if navigation is fixed
			}

			$page_template = get_post_meta($post->ID, '_wp_page_template', true);

			if($page_template == 'page-portfolio.php' ||  $page_template == 'page-portfolio-four-columns.php'){
				$classes[] = 'page-portfolio-isotope';
			}

		}



		return $classes;
	}

	/**
	 * Get align class
	 * @param $default
	 * @param string $option
	 * @return string
	 */
	function smartlib_algin_text($default, $option='left'){
		$class=$default;
		if($option=='left'){
			$class = ' text-left';
		}elseif($option=='center') {
			$class = ' text-center';
		}elseif($option=='right') {
			$class = ' text-right';
		}

		return $class;
	}

	function smartlib_conditional_class($default_string, $theme_mod, $value){
		$option = get_theme_mod($theme_mod);

		if($option==$value){
			return ' smartlib-force-display';
		}else{
			return $default_string;
		}
	}

	function smartlib_prevnext_link_attributes(){
		return 'class="btn btn-primary"';
	}

	function smartlib_portfolio_filter_string($default_string){
		global $post;
		$terms = get_the_terms($post->ID, 'portfolio_category');

		$terms_string = '[';
		if(count($terms)>0){
			foreach($terms as $term){
				$terms_string.= '"'.$term->slug .'"' .',';
			}
			return $terms_string .' "all"]';
		}else{
			return $default_string;
		}
	}


	/**
	 * Return config array - usful for plugin
	 * @return mixed
	 */
	function smartlib_get_theme_config(){
		return $this->default_config;
	}

	/**
	 * Add rel atribute to wordpress gallery
	 * @param $link
	 * @return mixed
	 */
	function smartlib_add_rel_attribute($link) {
		global $post;

		$switch_pretty_photo = get_theme_mod('section_smartlib_gallery_pretty_photo', 1);

		if($switch_pretty_photo ==1){
			return str_replace('<a href', '<a rel="smartlib-resize-photo[gallery]" href', $link);
		}else{
			return $link;
		}


	}


	/**
	 * Get Page Header Class
	 * @param $default
	 * @param $dark_section
	 * @return string
	 */

	function smartlib_page_header_class($default, $dark_section=1, $paralax_section=0, $overlay=''){

		$header_class = $default;

		if($dark_section ==1){
			$header_class .= ' smartlib-dark-section';
		}

		if($paralax_section==1){
			$header_class .= ' smartlib-paralax-container';
		}

		if(strlen($overlay)>0){
			$header_class .= ' smartlib-overlay-over-background';
		}



		return $header_class;

	}


}