<?php
/**
 * Social bar group
 * @package encase
 * @since 1.0.0
 */
$options = get_theme_mods();						
	if (!empty($options['twitter_uid'])) echo '<a title="'. esc_attr('Twitter', 'encase') .'" href="' . esc_url($options['twitter_uid']) . '" target="_blank"><i class="fa fa-twitter"></i></a>';
	if (!empty($options['facebook_uid'])) echo '<a title="'. esc_attr('Facebook', 'encase') .'" href="' . esc_url($options['facebook_uid']) . '" target="_blank"><i class="fa fa-facebook"></i></a>';
	if (!empty($options['google_uid'])) echo '<a title="'. esc_attr('Google+', 'encase') .'" href="' . esc_url($options['google_uid']). '" target="_blank"><i class="fa fa-google-plus"></i></a>';			
	if (!empty($options['linkedin_uid'])) echo '<a title="'. esc_attr('Linkedin', 'encase') .'" href="' . esc_url($options['linkedin_uid']) . '" target="_blank"><i class="fa fa-linkedin"></i></a>';
	if (!empty($options['pinterest_uid'])) echo '<a title="'. esc_attr('Pinterest', 'encase') .'" href="' . esc_url($options['pinterest_uid']) . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
	if (!empty($options['flickr_uid'])) echo '<a title="'. esc_attr('Flickr', 'encase') .'" href="' . esc_url($options['flickr_uid'] ). '" target="_blank"><i class="fa fa-flickr"></i></a>';
	if (!empty($options['youtube_uid'])) echo '<a title="'. esc_attr('Youtube', 'encase') .'" href="' . esc_url($options['youtube_uid']) . '" target="_blank"><i class="fa fa-youtube"></i></a>';
	if (!empty($options['vimeo_uid'])) echo '<a title="'. esc_attr('Vimeo', 'encase') .'" href="' . esc_url($options['vimeo_uid']) . '" target="_blank"><i class="fa fa-vimeo-square"></i></a>';		
	if (!empty($options['instagram_uid'])) echo '<a title="'. esc_attr('Instagram', 'encase') .'" href="' . esc_url($options['instagram_uid']) . '" target="_blank"><i class="fa fa-instagram"></i></a>';		
	if (!empty($options['reddit_uid'])) echo '<a title="'. esc_attr('Reddit', 'encase') .'" href="' . esc_url($options['reddit_uid']) . '" target="_blank"><i class="fa fa-reddit"></i></a>';
	if (!empty($options['stumbleupon_uid'])) echo '<a title="'. esc_attr('stumbleupon', 'encase') .'" href="' . esc_url($options['stumbleupon_uid']) . '" target="_blank"><i class="fa fa-stumbleupon"></i></a>';	
	if (!empty($options['wp_uid'])) echo '<a title="'. esc_attr('WordPress', 'encase') .'" href="' . esc_url($options['wp_uid']) . '" target="_blank"><i class="fa fa-wordpress"></i></a>';	
	if (!empty($options['github_uid'])) echo '<a title="'. esc_attr('Github', 'encase') .'" href="' . esc_url($options['github_uid']) . '" target="_blank"><i class="fa fa-github"></i></a>';
	if (!empty($options['dribbble_uid'])) echo '<a title="'. esc_attr('Dribble', 'encase') .'" href="' . esc_url($options['dribbble_uid']) . '" target="_blank"><i class="fa fa-dribbble"></i></a>';		
	if (!empty($options['rss_uid'])) echo '<a title="'. esc_attr('rss', 'encase') .'" href="' . esc_url($options['rss_uid'] ). '" target="_blank"><i class="fa fa-rss"></i></a>';	
?>