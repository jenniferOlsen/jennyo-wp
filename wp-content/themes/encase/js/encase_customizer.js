/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */


jQuery(document).ready(function() {

	jQuery( '.wp-full-overlay-sidebar-content' ).prepend( '<a style="width: 80%; margin: 10px auto 5px auto; display: block; text-align: center;" href="http://www.styledthemes.com/encase-pro" class="button" target="_blank">'+ encase_button.pro +'</a>' );
	jQuery( '.wp-full-overlay-sidebar-content' ).prepend( '<a style="width: 80%; margin: 10px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/view/theme-reviews/encase?filter=5" class="button" target="_blank">'+ encase_button.review +'</a>' );

});