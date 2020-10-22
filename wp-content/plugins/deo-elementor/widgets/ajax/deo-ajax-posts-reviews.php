<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
* Render Posts
*/
function deo_render_reviews_posts( $query, $settings = array() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		deo_render_reviews_posts_content( $settings );		
	}
}

function deo_render_reviews_posts_content( $settings ) {
	$columns = ( ! empty( $settings['post_columns_mobile'] ) ? ' col-' . $settings['post_columns_mobile'] : '' ) . ( ! empty( $settings['post_columns_tablet'] ) ? ' col-md-' . $settings['post_columns_tablet'] : '' ) . ( ! empty( $settings['post_columns'] ) ? ' col-lg-' . $settings['post_columns'] : '' );
	?>

	<div class="<?php echo esc_attr( $columns ) ?>">
		<article <?php post_class( 'entry' ) ?>>
			<?php deo_render_reviews_posts_image( $settings ); ?>

			<div class="entry__body">
				<div class="entry__header">
					<?php deo_render_reviews_posts_category( $settings ); ?>
					<?php deo_render_reviews_posts_title( $settings ); ?>
					<?php deo_render_reviews_posts_meta( $settings ); ?>
				</div>

				<?php deo_render_reviews_posts_excerpt( $settings ); ?>
			</div>
		</article>
	</div> <!-- end col -->
	
	<?php
}

function deo_render_reviews_posts_category( $settings ) {
	if ( 'yes' !== $settings['category_hide'] ) {
		echo neotech_meta_category();
	}
}

function deo_render_reviews_posts_title( $settings ) { ?>
	<<?php esc_attr_e( $settings['title_size'] ); ?> class="entry__title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</<?php esc_attr_e( $settings['title_size'] ); ?>>
	<?php
}

function deo_render_reviews_posts_meta( $settings ) {

	if ( 'yes' !== $settings['date_hide'] || 'yes' !== $settings['reviews_hide'] ) { ?>
		<ul class="entry__meta">
			<?php if ( 'yes' !== $settings['date_hide'] ) : ?>
				<li class="entry__meta-date">
					<?php echo neotech_meta_date(); ?>
				</li>
			<?php endif; ?>
			<?php if ( function_exists( 'wp_review_show_total' ) && 'yes' !== $settings['reviews_hide'] ) : ?>
				<li class="entry__meta-rating">
					<?php wp_review_show_total(true, 'widget-top-reviews__rating', null, array('in_widget' => true)); ?>
				</li>
			<?php endif; ?>
		</ul>
	<?php }
}

function deo_render_reviews_posts_image( $settings ) {
	if ( 'yes' !== $settings['image_hide'] ) {
		if ( has_post_thumbnail() ) { ?>
			<div class="entry__img-holder">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<div class="thumb-container">
						<?php
						the_post_thumbnail(
							'neotech-post-grid-cat-thumb', array(
								'class' => 'entry__img',
							)
						); ?>
					</div>
				</a>
			</div>
		<?php }
	}
}

function deo_render_reviews_posts_excerpt( $settings ) {
	if ( 'yes' !== $settings['content_hide'] ) { ?>
		<div class="entry__excerpt">
			<?php
			if ( empty( $settings['content_length'] ) ) {
				the_excerpt();
			} else {
				echo '<p>' . wp_trim_words( get_the_content(), $settings['content_length'] ) . '</p>';
			} ?>
		</div>
		<?php
	}
}