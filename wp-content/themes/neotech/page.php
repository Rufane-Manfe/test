<?php
/**
 * Default Page Template
 *
 * @package Neotech
 * @since   Neotech 1.0.0
 */

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php
		// Check if the page built with Elementor
		if ( neotech_is_elementor_page() ) : ?>

			<main class="elementor-main-content site-main">
				<?php the_content(); ?>
			</main>

			<!-- Comments -->
			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="container">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div class="section-wrap page-section pb-40">
				<div class="container">
					<div class="row">
						<div class="<?php if ( 'fullwidth' !== deo_layout_type( 'page' ) ) { echo esc_attr( 'col-lg-8' ); } else { echo esc_attr( 'col-lg-12' ); } ?> page-content">
							<main class="site-main">

								<?php if ( get_theme_mod( 'deo_breadcrumbs_page_show', true ) ) {
									do_action( 'deo_breadcrumbs' );
								} ?>

								<h1 class="page-title"><?php the_title(); ?></h1>
								<?php if ( has_post_thumbnail() ): ?>
									<?php the_post_thumbnail( $size = 'post-thumbnail', array( 'class' => 'contact__img' ) ); ?>
								<?php endif; ?>
								<div class="entry__article clearfix">
									<?php the_content(); ?>
								</div>

								<?php
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
								?>

							</main>
						</div> <!-- .page-content -->

						<?php
							// Sidebar
							if ( 'fullwidth' !== deo_layout_type( 'page' ) ) {
								deo_sidebar();
							}
						?>

					</div>
				</div>
			</div>
	<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>