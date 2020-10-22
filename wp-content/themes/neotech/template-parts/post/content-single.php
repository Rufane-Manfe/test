<?php
/**
 * Single post
 *
 * @package Neotech
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry single-post__entry' ); ?>>
	<div class="single-post__entry-header entry__header">

		<?php if ( get_theme_mod( 'deo_meta_category_show', true ) ) : ?>
			<div class="single-post__entry-meta-category">                    
				<?php echo neotech_meta_category(); ?>
			</div>
		<?php endif; ?>

		<h1 class="single-post__entry-title"><?php the_title(); ?></h1>

		<?php if ( get_theme_mod( 'deo_meta_author_show', true ) || get_theme_mod( 'deo_meta_date_show', true ) || get_theme_mod( 'deo_meta_category_show', true ) || get_theme_mod( 'deo_meta_views_show', true ) || get_theme_mod( 'deo_meta_reading_time_show', true ) ) : ?>

			<ul class="single-post__entry-meta entry__meta">
				<?php if ( get_theme_mod( 'deo_meta_author_show', true ) ) : ?>
					<li>
						<div class="entry-author">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="entry-author__url" itemprop="name">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 35, null, null, array( 'class' => array( 'entry-author__img' ) ) ); ?>
								<span><?php esc_html_e( 'by ', 'neotech' ); ?></span>
								<span itemprop="author" itemscope itemtype="//schema.org/Person" class="entry-author__name">
									<?php the_author_meta( 'display_name' ); ?>
								</span>
							</a>
						</div>
					</li>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'deo_meta_date_show', true ) ) : ?>
					<li class="entry__meta-date">
						<?php echo neotech_meta_date(); ?>
					</li>
				<?php endif; ?>
				
				<?php if ( get_theme_mod( 'deo_meta_views_show', true ) ) : ?>
					<li>                    
						<span><?php echo neotech_meta_views(); ?></span>
					</li>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'deo_meta_reading_time_show', true ) ) : ?>
					<li>
						<span class="entry__meta-reading-time">
							<?php echo do_shortcode( '[read_meter]' ); ?>
						</span>
					</li>
				<?php endif; ?>

			</ul>
		<?php endif; ?>
	</div>

	<?php
		if ( get_theme_mod( 'deo_post_featured_image_show', true ) ) {
			$post_format = get_post_format( $post->ID );

			switch ( $post_format ) {

				case 'gallery':
					break;

				case 'video':
				case 'audio':

					$meta = get_post_meta( $post->ID, '_deo_meta_value_key', true );

					if ( wp_oembed_get( $meta ) ) : ?>
						<div class="embed-responsive embed-responsive-16by9 mb-30">
							<?php echo wp_oembed_get( $meta ); ?>
						</div>
					<?php elseif( has_post_thumbnail() ) : ?>
						<div class="entry__img-holder">
							<?php the_post_thumbnail( 'neotech-thumb-single-post', array( 'class' => 'entry__img' ) ); ?>
						</div>
					<?php endif;

					break;

				default:
					if ( has_post_thumbnail() ) : ?>
						<div class="entry__img-holder">
							<figure>
								<?php the_post_thumbnail( 'neotech-thumb-single-post', array( 'class' => 'entry__img' ) ); ?>
							</figure>
						</div>
				<?php
					endif;
			}
		}
	?>

	<div class="entry__article-holder">

		<?php if ( get_theme_mod( 'deo_post_share_icons_show', true ) && function_exists( 'deo_social_sharing_buttons' ) ) : ?>
			<!-- Share -->
			<div class="entry__share">
				<div class="entry__share-inner">
					<?php echo deo_social_sharing_buttons(); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Article -->
		<div class="entry__article clearfix">

			<?php the_content(); ?>

			<?php
				// Post Multi Page Pagination
				$defaults = array(
					'before'           => '<nav class="post-pagination">' . '<span>' . esc_html( 'Pages:', 'neotech' ) . '</span>',
					'after'            => '</nav>',
					'link_before'      => '<span class="post-pagination__number">',
					'link_after'       => '</span>',
					'next_or_number'   => 'number',
					'separator'        => ' ',
					'nextpagelink'     => esc_html( 'Next page', 'neotech' ),
					'previouspagelink' => esc_html( 'Previous page', 'neotech' ),
					'pagelink'         => '%',
					'echo'             => 1
				);

				wp_link_pages( $defaults );
			?>

		</div><!-- .entry__article -->
	</div>

	<?php if ( get_theme_mod( 'deo_post_tags_show', true ) ) : ?>
		<?php if ( has_tag( $tag ) ) : ?>
			<!-- Tags -->
			<div class="entry__tags">
				<span class="entry__tags-label"><?php echo esc_html__( 'Tags: ', 'neotech' ); ?></span>
				<?php the_tags( '', '', '' ); ?>
				<div class="clearfix"></div>
			</div> <!-- end tags -->
		<?php endif; ?>
	<?php endif; ?>

	

	<?php if ( get_theme_mod( 'deo_prev_next_post_pagination_show', true ) ) {
	 	// Prev / Next post pagination		
		deo_post_nav();
	} ?>

	<?php if ( get_theme_mod( 'deo_author_box_show', true ) ) {
		// Author Box
		deo_author_box();
	} ?>

	<?php if ( get_theme_mod( 'deo_related_posts_show', true ) ) {
		// Related Posts
		neotech_related_posts();
	} ?>

</article><!-- #post-## -->

<?php
	// Comments
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
?>