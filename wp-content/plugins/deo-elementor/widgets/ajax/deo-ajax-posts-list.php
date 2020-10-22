<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
* Render Posts
*/
function deo_render_list_posts( $query, $settings = array() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		deo_render_list_posts_content( $settings );		
	}
}

function deo_render_list_posts_content( $settings ) { ?>
	<article <?php post_class( 'entry post-list' ) ?>>
		<?php deo_render_list_posts_image( $settings ); ?>

		<div class="entry__body post-list__body">
			<div class="entry__header">
				<?php deo_render_list_posts_category( $settings ); ?>
				<?php deo_render_list_posts_title( $settings ); ?>
				<?php deo_render_list_posts_meta( $settings ); ?>
			</div>

			<?php deo_render_list_posts_excerpt( $settings ); ?>
		</div>
	</article>
	
	<?php
}

function deo_render_list_posts_category( $settings ) {
	if ( 'yes' !== $settings['category_hide'] ) {
		echo neotech_meta_category();
	}
}

function deo_render_list_posts_title( $settings ) { ?>
	<<?php esc_attr_e( $settings['title_size'] ); ?> class="entry__title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</<?php esc_attr_e( $settings['title_size'] ); ?>>
	<?php
}

function deo_render_list_posts_meta( $settings ) {

	if ( 'yes' !== $settings['date_hide'] || 'yes' !== $settings['author_hide'] ) { ?>
		<ul class="entry__meta">
			<?php if ( 'yes' !== $settings['date_hide'] ) : ?>
				<li class="entry__meta-date">
					<?php echo neotech_meta_date(); ?>
				</li>
			<?php endif; ?>
			<?php if ( 'yes' !== $settings['author_hide'] ): ?>
				<li class="entry__meta-author">
					<?php esc_html_e( 'by ', 'neotech' ); ?>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
						<?php the_author(); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	<?php }
}

function deo_render_list_posts_image( $settings ) {
	if ( 'yes' !== $settings['image_hide'] ) {
		if ( has_post_thumbnail() ) { ?>
			<div class="entry__img-holder post-list__img-holder">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<div class="thumb-container">
						<?php
						the_post_thumbnail(
							'neotech-post-list-thumb', array(
								'class' => 'entry__img',
							)
						); ?>
					</div>
				</a>
			</div>
		<?php }
	}
}

function deo_render_list_posts_excerpt( $settings ) {
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