<?php
/*
================================================================
LOCALIZATOIN
================================================================
*/
function encase_localization() {
	load_theme_textdomain( 'encase', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'encase_localization' );

/*
================================================================
CONTENT WIDTH
================================================================
*/
if ( !isset( $content_width ) )
	$content_width = 640;

if ( !function_exists( 'encase_content_width' ) ) {
    function encase_content_width() {
        if ( is_page_template( 'template-full-width.php' ) || is_attachment() ) {
            global $content_width;
            $content_width = 980;
        }
    }
}
add_action( 'template_redirect', 'encase_content_width' );

/*
================================================================
Widget Shortcode Init
================================================================
*/
add_filter('widget_text', 'do_shortcode');
/*
================================================================
THEME SETUP
================================================================
*/
if ( !function_exists( 'encase_theme_setup' ) ) {
    function encase_theme_setup() {
        
    	/*
		================================================================
		REGISTER NAV MENUS
		================================================================
		*/
 		register_nav_menu( 'header-menu', __( 'Header Menu', 'encase' ) );
   	 	//register_nav_menu( 'footer-menu', __( 'Footer Menu', 'encase' ) );

    	/* Configure WP 2.9+ thumbnails */
    	add_theme_support( 'post-thumbnails' );
    	
        add_image_size( 'encase_s', 300, 300, true );
        add_image_size( 'encase_m', 640, '', true );
        add_image_size( 'encase_l', 980, '', true );
        
        add_theme_support( 
            'post-formats', 
            array(
                'gallery',
                'link',
                'quote',
                'video',
                'audio'
            ) 
        );     

        add_theme_support( 'automatic-feed-links' );
        add_post_type_support( 'page', 'excerpt' );
        add_theme_support( "title-tag" );
            
    }
}

add_action( 'after_setup_theme', 'encase_theme_setup' );

/*
================================================================
ENQUEUE SCRIPTS AND JQUERY FILES
================================================================
*/
if ( !function_exists( 'encase_enqueue_scripts' ) ) {
	function encase_enqueue_scripts() {
	    wp_enqueue_script('jquery');
		wp_enqueue_script( 'encase_slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', 'jquery', '1.0' );
		wp_enqueue_script( 'encase_custom', get_template_directory_uri() . '/js/jquery.custom.js', 'jquery', '1.0', TRUE );
		wp_enqueue_script( 'encase_scripts', get_template_directory_uri() . '/js/scripts.js', 'jquery', '1.0', TRUE );
		wp_enqueue_script( 'encase_fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', 'jquery', '1.0.3' );
		if ( is_singular( 'post' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
				
		/* SSL Check */
		$protocol = is_ssl() ? 'https' : 'http';
		
		wp_enqueue_style( 'googlefont-raleway', $protocol . '://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700,400italic' );
		wp_enqueue_style( 'style', get_stylesheet_uri(), FALSE, '1.0' );

		wp_enqueue_style( 'encase_fontwesome', get_template_directory_uri() . '/css/font-awesome.min.css', FALSE, '4.0.3' );
		wp_enqueue_style( 'encase_responsive', get_template_directory_uri() . '/css/responsive.css', FALSE, '1.0' );

    }
}

add_action( 'wp_enqueue_scripts', 'encase_enqueue_scripts' );


/*
================================================================
ENQUEUE ADMIN SCRIPTS AND JQUERY FILES
================================================================
*/
if ( !function_exists( 'encase_enqueue_admin_scripts' ) ) {
    function encase_enqueue_admin_scripts() {
        wp_register_script( 'encase-admin', get_template_directory_uri() . '/includes/js/jquery.custom.admin.js', 'jquery' );
        wp_enqueue_script( 'encase-admin' );

    }
}
add_action( 'admin_enqueue_scripts', 'encase_enqueue_admin_scripts' );

/*
================================================================
EXCLUDE FROM SCRATCH
================================================================
*/
if ( !function_exists( 'encase_exclude_pages_in_search' ) ) {
    function encase_exclude_pages_in_search( $query ) {
        if ( $query->is_search ) {
            $query->set( 'post_type', 'post' );
        }
    return $query;
    }
}

add_filter( 'pre_get_posts','encase_exclude_pages_in_search' );

/*
================================================================
COMMENTS
================================================================
*/

if ( !function_exists( 'encase_comment' ) ) {

	function encase_comment( $comment, $args, $depth ) {
	
        $GLOBALS['comment'] = $comment; ?>
        
        <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	        <article class="clearfix" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
				<?php echo get_avatar( $comment,$size='80' ); ?>
		        <div class="comment-author">
					<p class="vcard" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">
						<cite class="fn" itemprop="name"><?php comment_author_link(); ?></cite>
						<time itemprop="commentTime" datetime="<?php comment_time( 'c' ); ?>">
							<?php comment_date( 'm.d.Y' ); ?>
						</time>
			            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
			            <?php edit_comment_link( __( 'Edit', 'encase'), ' &middot; ', '' ) ?>
					</p>
		        </div>
				<div class="comment-content" itemprop="commentText">
		            <?php comment_text() ?>
		            <?php if ( $comment->comment_approved == '0' ) : ?>
		                <p><em class="awaiting"><?php _e( 'Your comment is awaiting moderation.', 'encase' ) ?></em></p>
		            <?php endif; ?>
				</div>
	        </article>
		</li>

<?php }
}

/*
================================================================
MORE LINK
================================================================
*/

function encase_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, __( 'Continue Reading', 'encase' ), $more_link );
}

add_filter( 'the_content_more_link', 'encase_more_link', 10, 2 );


/*
================================================================
CHECK IF IT'S BLOG
================================================================
*/

function is_blog() {
	global $post;
	$posttype = get_post_type( $post );
	return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) && ( $posttype == 'post' )  ) ? true : false;
}

/*
================================================================
POST FORMAT: GALLERY
================================================================
*/

	
function encase_gallery( $post_id ) {

	global $post;
	$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

	if ( $images ) :

		foreach ( $images as $attachment_id => $image ) :

			$img_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			if ( $img_alt == '' ) :
				$img_alt = $image->post_title;
			endif;

			if ( post_type_exists( 'portfolio' ) && is_singular( 'portfolio' ) ) :
				$array = image_downsize( $image->ID, 'l' );
			else :
				$array = image_downsize( $image->ID, 'm' );
			endif;

			$img_url = $array[0];

			?>

			<li>
				<img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" />
			</li>

			<?php

	endforeach;

	endif;

}

/*
================================================================
ADD .POST-THUMB CLASS TO POST IF HAS POST THUMB
================================================================
*/

function encase_has_post_thumb( $classes ) {    
	global $post;
	if ( isset ( $post->ID ) && get_the_post_thumbnail( $post->ID ) ) {
		$classes[] = 'post-thumb';
	}
	return $classes;
}

add_filter( 'post_class', 'encase_has_post_thumb' );


/*
================================================================
Include INITS
================================================================
*/
/**
 * Registers our main widget area and the front page widget areas.
 */
 
function encase_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Blog Sidebar', 'encase' ),
		'id' => 'sidebar-blog',
		'description' => __( 'Widgets placed here will display in the sidebar on both blog and post pages.', 'encase' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar( array(
		'name' => __( 'Pages Sidebar', 'encase' ),
		'id' => 'sidebar-page',
		'description' => __( 'Widgets placed here will display in the sidebar on pages.', 'encase' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
}
add_action( 'widgets_init', 'encase_widgets_init' );

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {
	
	    $optionsframework_settings = get_option('optionsframework');
	
	    // Gets the unique option id
	    $option_name = $optionsframework_settings['id'];
	
	    if ( get_option($option_name) ) {
		    $options = get_option($option_name);
	    }
		
	    if ( isset($options[$name]) ) {
		    return $options[$name];
	    } else {
		    return $default;
	    }
    }
}

/**
 * Adds customizable styles to your <head>
 */
function encase_theme_customize_css()
{
    get_template_part('css/customizecss');
}
add_action( 'wp_head', 'encase_theme_customize_css');



/*
================================================================
REQUIRED CUSTOMIZER LOAD
================================================================
*/
require_once dirname( __FILE__ ) . '/includes/customizer.php';


//load custom-header 
require_once dirname( __FILE__ ) . '/includes/custom-header.php';