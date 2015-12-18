<?php

/* ----------------------------------------------------------------

   Name: Mighty Theme Options
   URI: http://meetmighty.com/
   Description: Add options to theme
 
-----------------------------------------------------------------*/


/* ----------------------------------------------------------------
   UNIQUE IDENTIFIER
-----------------------------------------------------------------*/

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace( "/\W/", "_", strtolower( $themename ) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


/* ----------------------------------------------------------------
   THEME OPTIONS
-----------------------------------------------------------------*/

function optionsframework_options() {

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ( $options_pages_obj as $page ) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/includes/framework/images/';

	// Define values for editor use in theme options
	$wp_editor_settings = array(
		'wpautop' => false,
		'textarea_rows' => 2,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	// Email providers
	$providers = array(
		'fb' => 'FeedBurner',
		'mc' => 'MailChimp',
		'cm' => 'Campaign Monitor'
	);

	$options = array();


	// General

	$options[] = array(
		'name' => __('General', 'encase'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Plain Text Logo', 'encase'),
		'desc' => __('Check this box if you would like to use a plain text logo.', 'encase'),
		'id' => 'logo-plain',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Upload Custom Logo', 'encase'),
		'desc' => __('Upload a custom logo to use in the themes header.', 'encase'),
		'id' => 'logo-custom',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Upload Custom Favicon', 'encase'),
		'desc' => __('Upload a 16x16 pixel .GIF or .PNG image tto replace the default favicon.', 'encase'),
		'id' => 'custom-favicon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('FeedBurner URL', 'encase'),
		'desc' => __('Enter your full URL of your FeedBurner feed (or any other preferred feed URL).', 'encase'),
		'id' => 'feedburner-url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Site Analytics', 'encase'),
		'desc' => __('Enter in the code snippet for any site analytics (Google or other).', 'encase'),
		'id' => 'footer-scripts',
		'type' => 'textarea');


	// Style

	$options[] = array(
		'name' => __('Style', 'encase'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Link & Accent Color', 'encase'),
		'desc' => __('This changes both the link and accent color used in the theme.', 'encase'),
		'id' => 'accent-color',
		'std' => '#0274be',
		'type' => 'color' );
		
	$options[] = array(
		'name' => __('Custom CSS', 'encase'),
		'desc' => __('Enter any small style (CSS) changes you would like toe either add or overwrite. If there are many changes, please consider <a href="http://codex.wordpress.org/Child_Themes">creating a child theme</a>.', 'encase'),
		'id' => 'custom-css',
		'type' => 'textarea');


	// Front Page

	$options[] = array(
		'name' => __('Homepage', 'encase'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Main Heading', 'encase'),
		'desc' => __('Enter the text for the main heading in the header area.', 'encase'),
		'id' => 'billboard-heading',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Sub Heading', 'encase'),
		'desc' => __('Enter the text for the sub heading in the header area.', 'encase'),
		'id' => 'billboard-subhead',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Button Link', 'encase'),
		'desc' => __('Enter the text for the main heading in the billboard area.', 'encase'),
		'id' => 'billboard-btn-link',
		'type' => 'text');

	$options[] = array(
		'name' => __('Button Text', 'encase'),
		'desc' => __('Enter the text you would like to appear on the call-to-action button.', 'encase'),
		'id' => 'billboard-btn-text',
		'type' => 'text');

	$options[] = array(
		'name' => __('Quote Button Link', 'encase'),
		'desc' => __('Enter the link for the Quote button.', 'encase'),
		'id' => 'billboard-quote-link',
		'type' => 'text');

	$options[] = array(
		'name' => __('Quote Button Text', 'encase'),
		'desc' => __('Enter the text you would like to appear on the quote call-to-action button.', 'encase'),
		'id' => 'billboard-quote-text',
		'type' => 'text');

	$options[] = array(
		'name' => __('Text Columns Section', 'encase'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Section', 'encase'),
		'desc' => __('Check this box if you would like to hide this section from showing on your homepage.', 'encase'),
		'id' => 'text-display',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Main Heading', 'encase'),
		'desc' => __('Enter the text for the main heading in the column section on your homepage.', 'encase'),
		'id' => 'column-heading',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Sub Heading', 'encase'),
		'desc' => __('Enter the text for the sub heading in the column section on your homepage.', 'encase'),
		'id' => 'column-subhead',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Left Column Icon', 'encase'),
		'desc' => __('Go to <a href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome</a> and copy the icon name you want to use (Ex: fa-magic).', 'encase'),
		'id' => 'text-left-icon',
		'type' => 'text');

	$options[] = array(
		'name' => __('Left Column Heading', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-left-heading',
		'type' => 'text');

	$options[] = array(
		'name' => __('Left Column Text', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-left-content',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Center Column Icon', 'encase'),
		'desc' => __('Go to <a href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome</a> and copy the icon name you want to use (Ex: fa-magic).', 'encase'),
		'id' => 'text-center-icon',
		'type' => 'text');

	$options[] = array(
		'name' => __('Center Column Heading', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-center-heading',
		'type' => 'text');

	$options[] = array(
		'name' => __('Center Column Text', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-center-content',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Right Column Icon', 'encase'),
		'desc' => __('Go to <a href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome</a> and copy the icon name you want to use (Ex: fa-magic).', 'encase'),
		'id' => 'text-right-icon',
		'type' => 'text');

	$options[] = array(
		'name' => __('Right Column Heading', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-right-heading',
		'type' => 'text');

	$options[] = array(
		'name' => __('Right Column Text', 'encase'),
		'desc' => __('Enter text to use for the column heading.', 'encase'),
		'id' => 'text-right-content',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Portfolio Section', 'encase'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Section', 'encase'),
		'desc' => __('Check this box if you would like to hide this section from showing on your homepage.', 'encase'),
		'id' => 'portfolio-display',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Main Heading', 'encase'),
		'desc' => __('Enter the text for the main heading in the portfolio section.', 'encase'),
		'id' => 'portfolio-heading',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Sub Heading', 'encase'),
		'desc' => __('Enter the text for the sub heading in the portfolio section.', 'encase'),
		'id' => 'portfolio-subhead',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Blog Posts Section', 'encase'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Section', 'encase'),
		'desc' => __('Check this box if you would like to hide this section from showing on your homepage.', 'encase'),
		'id' => 'blog-display',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Main Heading', 'encase'),
		'desc' => __('Enter the text for the main heading in the blog posts section on your homepage.', 'encase'),
		'id' => 'blog-heading',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Sub Heading', 'encase'),
		'desc' => __('Enter the text for the sub heading in the blog posts section on your homepage.', 'encase'),
		'id' => 'blog-subhead',
		'type' => 'textarea');
		
				
	// Footer

	$options[] = array(
		'name' => __('Footer', 'encase'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Email Newsletter Section', 'encase'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Section', 'encase'),
		'desc' => __('Check this box if you would like to hide this section from showing on your homepage.', 'encase'),
		'id' => 'email-display',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Main Heading', 'encase'),
		'desc' => __('Enter the text for the main heading in this section on your homepage.', 'encase'),
		'id' => 'email-heading',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Sub Heading', 'encase'),
		'desc' => __('Enter the text for the sub heading in this section section on your homepage.', 'encase'),
		'id' => 'email-subhead',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Email Provider', 'encase'),
		'desc' => __('Select your preferred email provider', 'encase'),
		'id' => 'email-provider',
		'std' => 'fb',
		'type' => 'radio',
		'options' => $providers);

	$options[] = array(
		'name' => __('FeedBurner ID', 'encase'),
		'desc' => __('Enter your FeedBurner ID into the field. (Example: http://feeds2.feedburner.com/<strong>FeedBurnerID</strong>).', 'encase'),
		'id' => 'fb-id',
		'type' => 'text');

	$options[] = array(
		'name' => __('MailChimp Form Action URL', 'encase'),
		'desc' => __('Enter the URL to post the MailChimp sign-up to. (<a href="http://docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action">See a tutorial on how to locate it</a>.)', 'encase'),
		'id' => 'mc-url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Campaign Monitor Form Action URL', 'encase'),
		'desc' => __('Enter the URL to post the Campaign Monitor sign-up to. (<a href="http://cl.ly/UGKO/o">See a tutorial on how to locate it</a>)', 'encase'),
		'id' => 'cm-url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Campaign Monitor Email Field Name', 'encase'),
		'id' => 'cm-name',
		'type' => 'text');

	$options[] = array(
		'name' => __('Footer Section', 'encase'),
		'type' => 'info');
		
	$options[] = array(
		'name' => __('Facebook', 'encase'),
		'desc' => __('Enter the url for your Facebook profile. (https://www.facebook.com/MightyThemes)', 'encase'),
		'id' => 'social-facebook',
		'type' => 'text' );
		
	$options[] = array(
		'name' => __('Twitter', 'encase'),
		'desc' => __('Enter the url for your Twitter profile. (https://twitter.com/MeetMighty)', 'encase'),
		'id' => 'social-twitter',
		'type' => 'text');

	$options[] = array(
		'name' => __('Copyright Text', 'encase'),
		'desc' => __('Enter in your desired copyright text.', 'encase'),
		'id' => 'copyright',
		'type' => 'text');

	return $options;
}