<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Dusk To Dawn
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses dusk_to_dawn_header_style()
 * @uses dusk_to_dawn_admin_header_style()
 * @uses dusk_to_dawn_admin_header_image()
 *
 * @package Dusk To Dawn
 */
function dusk_to_dawn_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'dusk_to_dawn_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '497ca7',
		'width'                  => 870,
		'height'                 => 220,
		'wp-head-callback'       => 'dusk_to_dawn_header_style',
		'admin-head-callback'    => 'dusk_to_dawn_admin_header_style',
		'admin-preview-callback' => 'dusk_to_dawn_admin_header_image',
	 ) ) );
}
add_action( 'after_setup_theme', 'dusk_to_dawn_custom_header_setup' );

if ( ! function_exists( 'dusk_to_dawn_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see dusk_to_dawn_custom_header_setup().
 */
function dusk_to_dawn_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		#branding hgroup,
		#site-title,
		#site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		#page {
			padding: 132px 0 0 0;
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // dusk_to_dawn_header_style

if ( ! function_exists( 'dusk_to_dawn_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see dusk_to_dawn_custom_header_setup().
 */
function dusk_to_dawn_admin_header_style() {
?>
	<style type="text/css">
		#headimg {
			width: <?php echo get_custom_header()->width; ?>px;
			height: <?php echo get_custom_header()->height; ?>px;
		}
		#heading,
		#headimg h1,
		#headimg #desc {
			display: none;
		}
	</style>
<?php
}
endif; // dusk_to_dawn_admin_header_style

if ( ! function_exists( 'dusk_to_dawn_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see dusk_to_dawn_custom_header_setup().
 */
function dusk_to_dawn_admin_header_image() {
	$header_image = get_header_image();
?>
	<div id="headimg">
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}
endif; // dusk_to_dawn_admin_header_image
