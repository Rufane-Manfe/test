<?php defined('ABSPATH') OR die('restricted access');


function neotech_get_ids( $ids = '' ) {
	return $ids;
}

function neotech_render_ids() {
	echo neotech_get_ids();
}

if ( ! function_exists( 'neotech_meta_category' ) ) {
	function neotech_meta_category() {
		$categories = get_the_category();
		$separator = ' ';
		$categories_output = '';
		$output = '';

		if ( !empty($categories) ):
			foreach( $categories as $index => $category ):
				if ($index > 0) : $categories_output .= $separator; endif;
				$categories_output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="entry__meta-category">' . esc_html( $category->name ) . '</a>';
			endforeach;
		endif;

		if ( 'post' == get_post_type() ) :
			$output .= $categories_output;
		endif;

		return $output;

	}
}



if ( ! function_exists( 'neotech_meta_date' ) ) {
	/**
	* Post date meta
	*/
	function neotech_meta_date() {
		$posted_on = ( get_theme_mod( 'deo_meta_time_show', false ) ) ? get_the_date() . esc_html( ' at ', 'neotech' ) . get_post_time( 'g:i A' ) : get_the_date();
		$output = '';
		$output .= sprintf('<span>%s</span>', $posted_on);

		return $output;
	}
}


if ( ! function_exists( 'neotech_meta_comments' ) ) {
	/**
	* Post comments meta
	*/
	function neotech_meta_comments() {
		$comments_num = get_comments_number();
		$output = '';

		if ( comments_open() ) {
			if( $comments_num == 0 ) {
				$comments = esc_html__( '0 Comments', 'neotech' );
			} elseif ( $comments_num > 1 ) {
				$comments = $comments_num . esc_html__(' Comments', 'neotech');
			} else {
				$comments = esc_html__('1 Comment', 'neotech');
			}
			$comments = sprintf('<a href="%1$s">%2$s</a>', get_comments_link(), $comments );
		} else {
			$comments = esc_html__('Comments are closed', 'neotech');
		}

		$output .= $comments;
		return $output;
	}
}


if ( ! function_exists( 'neotech_meta_views' ) ) {
	/**
	* Post meta views
	*/
	function neotech_meta_views() {
		$views = get_post_meta( get_the_ID(), '_deo_post_views', true );		
		$meta_views = sprintf( esc_html__( 'Views: %s', 'neotech' ), esc_html( $views ) );
		
		return $meta_views;
	}
}


if ( ! function_exists( 'neotech_related_posts' ) ) {
	/**
	* Related Posts
	*/
	function neotech_related_posts() {
		global $post;
		$tags = wp_get_post_tags( $post->ID );
		$author_id = get_the_author_meta( 'ID' );
		$related_by = get_theme_mod( 'deo_related_posts_relation', 'category' );

		$args = array(
			'post_type'             => 'post',
			'post_status'           => 'publish',
			'posts_per_page'        => 3,
			'post__not_in'          => array( get_the_ID() ),
			'no_found_rows'         => true,
			'ignore_sticky_posts'   => true,
			'meta_query' => array(
				array(
					'key' => '_thumbnail_id'
				)
			),
		);

		if ( $tags && 'tag' === $related_by ) {
			$tag_ids = array();
			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}

			$args['tag__in'] = $tag_ids;
			
		} elseif ( 'category' === $related_by ) {
			$args['category__in'] = wp_get_post_categories( get_the_ID() );
		} elseif ( 'author' === $related_by ) {        
			$args['author'] = $author_id;
		}

		$query = new WP_Query( $args ); ?>

		<?php if ( $query->have_posts() ) : ?>

			<div class="related-posts">
				<h5 class="related-posts__title"><?php echo esc_html__( 'You Might Like', 'neotech'); ?></h5>
				<div class="row row-20">

					<?php while( $query->have_posts() ) : $query->the_post(); ?>

						<div class="col-md-4">
							<article <?php post_class( 'related-posts__entry entry' ); ?>>

								<?php if ( has_post_thumbnail() ) : ?>
									<!-- Post thumb -->
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<div class="thumb-container">
											<?php the_post_thumbnail( 'neotech-related-thumb', array( 'class' => 'entry__img' ) ); ?>
										</div>
									</a>
								<?php endif; ?>

								<div class="related-posts__text-holder">
									<?php the_title( sprintf( '<h2 class="related-posts__entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								</div>

							</article><!-- #post-## -->
						</div>

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				</div> <!-- .row -->
			</div> <!-- .related-posts -->
		<?php endif;
	}
}


/**
 * Custom excerpt length
 */
function deo_custom_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'deo_posts_excerpt_settings', 20 );
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'deo_custom_excerpt_length', 999 );


/**
 * Replace excerpt dotslength
 */
function deo_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'deo_excerpt_more', 21 );