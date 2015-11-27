<?php
/**
 * The template for displaying Comments.
 *
 */
if (post_password_required())
    return;

/*
 * Display Comments list and form only if comments are open
 */

	if(comments_open()):
?>
		<div id="comments" class="comments-area">

    <?php // You can start editing here -- including this comment! ?>




	<?php if ( have_comments() ) : ?>

	<h3 class="smartlib-comments-title">
					<?php
					printf(_n('1 comment', '%1$s comments', get_comments_number(), 'bootframe-core'),
						number_format_i18n(get_comments_number()));
					?>
	</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'bootframe-core' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'bootframe-core' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'bootframe-core' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
			<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list smartlib-comments-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'callback' => 'smartlib_comment_template',
				'short_ping' => true,

			) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'bootframe-core' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'bootframe-core' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'bootframe-core' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php endif; // Check for comment navigation. ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'bootframe-core' ); ?></p>
			<?php endif; ?>

		<?php endif; // have_comments() ?>

	<?php comment_form(array('class_submit' => 'btn btn-primary')); ?>


</div><!-- #comments .comments-area -->
<?php
	endif; // end if comments open
?>