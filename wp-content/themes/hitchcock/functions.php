<?php

// Theme setup
add_action( 'after_setup_theme', 'hitchcock_setup' );

function hitchcock_setup() {
	
	// Automatic feed
	add_theme_support( 'automatic-feed-links' );
	
	// Set content-width
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 600;
	
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'post-image', 1240, 9999 );
	add_image_size( 'post-thumb', 508, 9999 );
	
	// Title tag
	add_theme_support( 'title-tag' );
	
	// Custom header
	$args = array(
		'width'         => 1440,
		'height'        => 900,
		'default-image' => get_template_directory_uri() . '/images/bg.jpg',
		'uploads'       => true,
		'header-text'  	=> false
		
	);
	add_theme_support( 'custom-header', $args );
	
	// Post formats
	add_theme_support( 'post-formats', array( 'gallery' ) );
		
	// Jetpack infinite scroll
	add_theme_support( 'infinite-scroll', array(
		'type' 				=> 		'click',
	    'container'			=> 		'posts',
	    'wrapper'			=>		false,
		'footer' 			=> 		false,
	) );
	
	// Add nav menu
	register_nav_menu( 'primary', __('Primary Menu','hitchcock') );
	register_nav_menu( 'social', __('Social Menu','hitchcock') );
	
	// Make the theme translation ready
	load_theme_textdomain('hitchcock', get_template_directory() . '/languages');
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
	  require_once($locale_file);
	
}


// Register and enqueue Javascript files
function hitchcock_load_javascript_files() {

	if ( !is_admin() ) {		
		wp_enqueue_script( 'hitchcock_flexslider', get_template_directory_uri().'/js/flexslider.js', array('jquery'), '', true );
		wp_enqueue_script( 'hitchcock_doubletaptogo', get_template_directory_uri().'/js/doubletaptogo.js', array('jquery'), '', true );
		wp_enqueue_script( 'hitchcock_global', get_template_directory_uri().'/js/global.js', array('jquery'), '', true );
		
		if ( is_singular() ) { 
			wp_enqueue_script( "comment-reply" );
		}
		
	}
}

add_action( 'wp_enqueue_scripts', 'hitchcock_load_javascript_files' );


// Register and enqueue styles
function hitchcock_load_style() {
	if ( !is_admin() ) {
	    wp_enqueue_style( 'hitchcock_googleFonts', '//fonts.googleapis.com/css?family=Montserrat:400,700|Droid+Serif:400,400italic,700,700italic' );
	    wp_enqueue_style( 'hitchcock_fontawesome', get_stylesheet_directory_uri() . '/fa/css/font-awesome.css' );
	    wp_enqueue_style( 'hitchcock_style', get_stylesheet_uri() );
	}
}

add_action('wp_print_styles', 'hitchcock_load_style');


// Add editor styles
function hitchcock_add_editor_styles() {
    add_editor_style( 'hitchcock-editor-styles.css' );
    $font_url = '//fonts.googleapis.com/css?family=Montserrat:400,700|Droid+Serif:400,400italic,700,700italic';
    add_editor_style( str_replace( ',', '%2C', $font_url ) );
}
add_action( 'init', 'hitchcock_add_editor_styles' );


// Check whether the browser supports javascript
function html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'html_js_class', 1 );


// Hitchcock archive navigation function
function hitchcock_archive_navigation() {
	
	global $wp_query;
	
	if ( $wp_query->max_num_pages > 1 ) : ?>
				
		<div class="archive-nav">
			
			<?php 
				if ( get_previous_posts_link() ) {
					previous_posts_link( '<span class="fa fw fa-angle-left"></span>' );
				} else {
					echo '<span class="fa fw fa-angle-left"></span>';
				} 
			?>
			<span class="sep">/</span>
			<?php 
				if ( get_next_posts_link() ) {
					next_posts_link( '<span class="fa fw fa-angle-right"></span>' );
				} else {
					echo '<span class="fa fw fa-angle-right"></span>';
				} 
			?>
			
			<div class="clear"></div>
				
		</div> <!-- /archive-nav-->
						
	<?php endif;
}


// Style the admin area
function hitchcock_admin_area_style() { 
   echo '
<style type="text/css">

	#postimagediv #set-post-thumbnail img {
		max-width: 100%;
		height: auto;
	}

</style>';
}

add_action('admin_head', 'hitchcock_admin_area_style');


// Add body classes to single pages
add_filter('body_class','hitchcock_post_class_to_page');
 
function hitchcock_post_class_to_page( $classes ){
 
    if ( is_page() || is_404() || ( is_search() && !have_posts() ) ) {
        $classes[] = 'post single';
    }
    
    return $classes;
}


// Add body class if is mobile
add_filter('body_class','hitchcock_is_mobile_body_class');
 
function hitchcock_is_mobile_body_class( $classes ){
 
    if ( wp_is_mobile() ) {
        $classes[] = 'wp-is-mobile';
    }
    
    return $classes;
}


// Flexslider function for format-gallery
function hitchcock_flexslider($size) {

	if ( is_page()) :
		$attachment_parent = $post->ID;
	else : 
		$attachment_parent = get_the_ID();
	endif;

	if($images = get_posts(array(
		'post_parent'    => $attachment_parent,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
                'orderby'        => 'menu_order',
                'order'           => 'ASC',
	))) { ?>
	
		<div class="flexslider">
		
			<ul class="slides">
	
				<?php foreach($images as $image) { 
				
					$attimg = wp_get_attachment_image($image->ID, $size); ?>
					
					<li>
						<?php echo $attimg; ?>
					</li>
					
				<?php }; ?>
		
			</ul>
			
		</div><?php
		
	}
}



// Related posts function
function hitchcock_related_posts() { ?>
	
<div class="related-posts posts section-inner">
			
	<?php 
							
		global $post;
		$cat_ID = array();
		$categories = get_the_category();
		foreach($categories as $category) {
			array_push($cat_ID,$category->cat_ID);
		}
		
		$related_posts = new WP_Query( apply_filters(
		'rowling_related_posts_args', array(
		        'posts_per_page'		=>	3,
		        'post_status'			=>	'publish',
		        'category__in'			=>	$cat_ID,
		        'post__not_in'			=>	array($post->ID),
		        'ignore_sticky_posts'	=>	true
		) ) );
		
		if ($related_posts->have_posts()) :
			
			while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
			
			<?php global $post; ?>
					
			<?php get_template_part( 'content', get_post_format() ); ?>
		
		<?php endwhile; ?>
			
	<?php else: // If there are no other posts in the post categories, get random posts ?>
	
		<?php
				
			$related_posts = new WP_Query( apply_filters(
			'rowling_related_posts_args', array(
			        'posts_per_page'		=>	3,
			        'post_status'			=>	'publish',
			        'orderby'				=>	'rand',
			        'post__not_in'			=>	array($post->ID),
			        'ignore_sticky_posts'	=>	true
			) ) );
			
			if ($related_posts->have_posts()) :
				
				while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
				
				<?php global $post; ?>
			
				<?php get_template_part( 'content', get_post_format() ); ?>
				
			<?php endwhile; ?>
			
		<?php endif; ?>

	<?php endif; ?>
			
	<div class="clear"></div>
	
	<?php wp_reset_query(); ?>

</div> <!-- /related-posts --> <?php
	
}


// Comment function
if ( ! function_exists( 'hitchcock_comment' ) ) :
function hitchcock_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	
		<?php __( 'Pingback:', 'hitchcock' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'hitchcock' ), '<span class="edit-link">', '</span>' ); ?>
		
	</li>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			
			<h4 class="comment-title">
				<?php echo get_comment_author_link(); ?>
				<span><a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>"><?php echo get_comment_date(get_option('date_format')) ?></a>
				<?php
					if ( $post = get_post($post->ID) ) {
			            if ( $comment->user_id === $post->post_author )
			               echo ' &mdash; ' . __('Post Author','hitchcock');
			        }
				?>
				</span>
			</h4>
									
			<div class="comment-content post-content">
			
				<?php comment_text(); ?>
				
			</div><!-- /comment-content -->
			
			<div class="comment-actions">
							
				<?php 
					comment_reply_link( array( 
						'reply_text' 	=>  	__('Reply','hitchcock'),
						'depth'			=> 		$depth, 
						'max_depth' 	=> 		$args['max_depth'],
						'before'		=>		'',
						'after'			=>		''
						) 
					); 
				?>
				
				<?php edit_comment_link( __( 'Edit', 'hitchcock' ), '', '' ); ?>
				
				<?php if ( '0' == $comment->comment_approved ) : ?>
				
					<p class="comment-awaiting-moderation fright"><?php _e( 'Your comment is awaiting moderation.', 'hitchcock' ); ?></p>
					
				<?php endif; ?>
								
			</div> <!-- /comment-actions -->
										
		</div><!-- /comment-## -->
				
	<?php
		break;
	endswitch;
}
endif;


// hitchcock theme options
class hitchcock_Customize {

   public static function hitchcock_register ( $wp_customize ) {
   
      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'hitchcock_logo_section' , array(
		    'title'       => __( 'Logo', 'hitchcock' ),
		    'priority'    => 40,
		    'description' => __('Upload a logo to replace the default site title in the sidebar/header', 'hitchcock'),
	  ) );
      
      
      //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#3bc492', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color'
         ) 
      );
	  
	  $wp_customize->add_setting( 'hitchcock_logo', 
      	array( 
      		'sanitize_callback' => 'esc_url_raw'
      	) 
      );
      
      
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'hitchcock_accent_color', //Set a unique ID for the control
         array(
            'label' => __( 'Accent Color', 'hitchcock' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'accent_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hitchcock_logo', array(
		    'label'    => __( 'Logo', 'hitchcock' ),
		    'section'  => 'hitchcock_logo_section',
		    'settings' => 'hitchcock_logo',
	  ) ) );
      
      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
   }

   public static function hitchcock_header_output() {
      ?>
      
	      <!-- Customizer CSS --> 
	      
	      <style type="text/css">
	           <?php self::hitchcock_generate_css('body a', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('body a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.blog-title a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.social-menu a:hover', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post:hover .archive-post-title', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content a', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content a:hover', 'border-bottom-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content p.pull', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content input[type="submit"]', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content input[type="button"]', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content input[type="reset"]', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content input:focus', 'border-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.post-content textarea:focus', 'border-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.button', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.page-links a:hover', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comments .pingbacks li a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-header h4 a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-form input:focus', 'border-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-form textarea:focus', 'border-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.form-submit #submit', 'background-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-title .url:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-actions a', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.comment-actions a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.archive-nav a:hover', 'color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('#infinite-handle:hover', 'background', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.credits p:first-child a:hover', 'color', 'accent_color'); ?>
	           
	           <?php self::hitchcock_generate_css('.nav-toggle.active .bar', 'background-color', 'accent_color'); ?>
	           <?php self::hitchcock_generate_css('.mobile-menu a:hover', 'color', 'accent_color'); ?>
	           
	      </style> 
	      
	      <!--/Customizer CSS-->
	      
      <?php
   }
   
   public static function hitchcock_live_preview() {
      wp_enqueue_script( 
           'hitchcock-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }

   public static function hitchcock_generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'hitchcock_Customize' , 'hitchcock_register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'hitchcock_Customize' , 'hitchcock_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'hitchcock_Customize' , 'hitchcock_live_preview' ) );

?>