<?php

class Deo_Walker_Comment extends Walker_Comment {

    /**
     * Outputs a comment in the HTML5 format.
     *
     * @since 3.6.0
     * @access protected
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
        <<?php echo esc_html($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

                <div class="comment-avatar vcard">
                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </div><!-- .comment-author -->

                <div class="comment-text">

                    <?php printf( '<h6 class="comment-author">%s</h6>', get_comment_author_link( $comment ) ) ?>

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="comment-date">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                    /* translators: 1: comment date, 2: comment time */
                                    printf( esc_html__( '%1$s at %2$s', 'neotech' ), get_comment_date( '', $comment ), get_comment_time() );
                                ?>
                            </time>
                        </a>
                        <?php edit_comment_link( esc_html__( 'Edit', 'neotech' ), '<span class="comment-edit-link">', '</span>' ); ?>
                    </div><!-- .comment-metadata -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'neotech' ); ?></p>
                    <?php endif; ?>

                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>'
                    ) ) );
                    ?>

                </div><!-- .comment-text -->


            </div><!-- .comment-body -->
<?php
    }
}