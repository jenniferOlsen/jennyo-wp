<?php

/**
 Layout Utility Class - methods preparing data to display
 */

class Smartlib_Layout_Helpers{

	static $instance;
	public $default_config;

	public function __construct( $conObj ) {
		self::$instance =& $this;

		$this->default_config = $conObj;

	}



	public function check_format_class_in_array($key_class){

		$formats_array = $this->default_config->get_promoted_formats();

		return (bool) in_array( $key_class, $formats_array );
	}

	/**
	 * Display related post component
	 *
	 * @param     $category of related articles
	 * @param     $post_ID
	 * @param     $display_post_limit
	 * @param int $columns_per_slide
	 */
	public function get_related_post_box( $category, $post_ID, $display_post_limit, $columns_per_slide = 4 ) {
		global $post;

		$args = array(
			'cat'           => $category,
			'post__not_in'  => array( $post_ID * - 1 ),
			'posts_per_page'=> $display_post_limit,
			'tax_query'     => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-gallery' )
				),
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-video' )
				),
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-standard' )
				)

			)
		);


		$query = new WP_Query( $args );


		return $query;

		//if limit >0

	}

	/**
	 * Get related portfolio works
	 * @param $term
	 * @param $post_ID
	 * @param $display_post_limit
	 * @return WP_Query
	 */

	public function get_related_portfolio_box( $term, $post_ID, $display_post_limit) {
		global $post;

		$args = array(

			'post__not_in'  => array( $post_ID * - 1 ),
			'posts_per_page'=> $display_post_limit,
			'tax_query'     => array(

				array(
					'taxonomy' => 'portfolio_category',
					'field'    => 'ID',
					'terms'    => array( $term )
				)


			)
		);


		$query = new WP_Query( $args );


		return $query;

		//if limit >0

	}
}

