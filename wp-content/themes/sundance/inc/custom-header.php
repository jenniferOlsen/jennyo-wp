<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Sundance
 * @since Sundance 1.0
 */

function sundance_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'sundance_custom_header_args', array(
		'default-text-color'     => '464646',
		'width'                  => apply_filters( 'sundance_header_image_width', 984 ),
		'height'                 => apply_filters( 'sundance_header_image_height', 242 ),
		'flex-height'            => true,
		'wp-head-callback'       => 'sundance_header_style',
		'admin-head-callback'    => 'sundance_admin_header_style',
		'admin-preview-callback' => 'sundance_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'sundance_custom_header_setup' );

if ( ! function_exists( 'sundance_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Sundance 1.0
 */
function sundance_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#page {
			padding-top: 7px;
		}
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		.header-image-link {
			margin-top: 0;
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // sundance_header_style

if ( ! function_exists( 'sundance_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Sundance 1.0
 */
function sundance_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
			max-width: 984px;
		}
		#headimg h1,
		#desc {
			font-family: 'Droid Serif', serif;
		}
		#headimg h1 {
			float: left;
			font-size: 44px;
			font-weight: normal;
			line-height: 52px;
			margin: 0 0 0 110px;
			max-width: 652px;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			float: right;
			font-size: 12px;
			font-style: italic;
			line-height: 22px;
			margin: 26px 0 0 0;
			max-width: 186px;
		}
		#headimg img {
			clear: both;
			height: auto;
			margin: 33px 0 0 0;
			max-width: 984px;
			width: 100%;
		}
	</style>
<?php
}
endif; // sundance_admin_header_style

if ( ! function_exists( 'sundance_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @since sundance 1.0
 */
function sundance_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( ! empty( $header_image ) ) : ?>
		<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}
endif; // sundance_admin_header_image