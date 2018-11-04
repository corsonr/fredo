<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Fredo
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="row section-title">
	<div class="column">
		<h2><span><?php printf( _nx( '1 comment', '%1$s comments', get_comments_number(), 'comments title', 'fredo' ), number_format_i18n( get_comments_number() ) ); ?></span></h2>
	</div>
</div>

<div class="row comments">
	<div class="column">

	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( 'callback=list_comments' );
				?>
			</ol><!-- .comment-list -->

			<?php
				// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				?>
				<nav class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text section-heading"><?php esc_attr_e( 'Comment navigation', 'fredo' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'fredo' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'fredo' ) ); ?></div>
				</nav>
			<?php endif; // Check for comment navigation. ?>

			<?php if ( ! comments_open() && get_comments_number() ) : ?>
				<p class="no-comments"><?php esc_attr_e( 'Comments are closed.', 'fredo' ); ?></p>
			<?php endif; ?>

		<?php endif; // have_comments(). ?>

		<?php comment_form(); ?>

	</div><!-- #comments -->
