<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Neotech
 */

?>

<article <?php post_class( 'entry' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<!-- Post thumb -->
		<div class="entry__img-holder">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'neotech-post-grid-cat-thumb', array( 'class' => 'entry__img' ) ); ?>
			</a>
		</div>
	<?php endif; ?>


	<div class="entry__body">

		<div class="entry__header">

			<?php if ( get_theme_mod( 'deo_meta_category_show', true ) ) : ?>
				<?php echo neotech_meta_category(); ?>
			<?php endif; ?>

			<?php the_title( sprintf( '<h2 class="entry__title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( get_theme_mod( 'deo_meta_date_show', true ) || get_theme_mod( 'deo_meta_author_show', true ) ) : ?>
				<ul class="entry__meta">

					<?php if ( get_theme_mod( 'deo_meta_date_show', true ) ) : ?>
						<li class="entry__meta-date">
							<?php echo neotech_meta_date(); ?>
						</li>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'deo_meta_author_show', true ) ) : ?>
						<li class="entry__meta-author">
							<?php esc_html_e( 'by', 'neotech' ); ?>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="entry-author__url d-inline-block" itemprop="name">
								<span itemprop="author" itemscope itemtype="//schema.org/Person">
									<?php the_author_meta( 'display_name' ); ?>
								</span>
							</a>
						</li>						

					<?php endif; ?>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Excerpt -->
		<?php if ( get_theme_mod( 'deo_post_excerpt_show', true ) ) : ?>
			<div class="entry__excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<!-- Read More -->
		<div class="entry__read-more">
			<a href="<?php the_permalink(); ?>" class="entry__read-more-url"><?php esc_html_e('Read More', 'neotech') ?></a>
		</div>

	</div> <!-- .entry__body -->

</article><!-- #post-## -->