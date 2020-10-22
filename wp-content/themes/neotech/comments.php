<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package neotech
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="entry-comments">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h5 class="entry-comments__title">
			<?php
				comments_number( esc_html__( 'No comments', 'neotech' ),
					esc_html__( '1 Comment', 'neotech' ),
					esc_html__( '% Comments', 'neotech' )
				);
			?>
		</h5>

		<?php the_comments_navigation(); ?>

		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'             => 'ul',
				'short_ping'        => true,
				'avatar_size'       => 40,
				'per_page'          => '',
				'reverse_top_level' => true,
				'walker'            => new Deo_Walker_Comment()
			) );
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

	endif; // Check for have_comments().

	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'neotech' ); ?></p>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();
		$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		$fields = array(
			'author' =>
			'<div class="row row-20"><div class="col-lg-4"><label for="author">' . esc_html__( 'Name', 'neotech' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required" /></div>',

			'email' =>
			'<div class="col-lg-4"><label for="email">' . esc_html__( 'Email', 'neotech' ) . '</label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required="required" /></div>',

			'url' =>
			'<div class="col-lg-4"><label for="url">' . esc_html__( 'Website', 'neotech' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div></div>',

			'cookies' =>
			'<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
	  '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'neotech' ) . '</label></p>'
		);

		$args = array(
			'class_submit'  => 'btn btn-lg btn-color btn-button',
			'title_reply_before' => '<h5 class="comment-respond__title">',
			'title_reply_after' => '</h5>',
			'comment_notes_before' => '',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html_x( 'Comment', 'noun', 'neotech' ) . '</label><textarea id="comment" name="comment" rows="5" required="required"></textarea></p>',
			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
			'submit_field' => '<p class="comment-form-submit">%1$s %2$s</p>',
		);

		comment_form( $args );

	?>

</div><!-- #comments -->
