<?php
/**
 * The template for displaying all single posts.
 *
 * @package Neotech
 */

get_header();
?>

<?php do_action( 'neotech_single_entry_section_before' ); ?>

<div class="section-wrap single-entry-section pb-20 pt-40">
	<div class="container">
		<div class="row <?php if ( 'fullwidth' == deo_layout_type( 'blog' ) ) { echo esc_attr( 'justify-content-center' ); } ?>">

			<!-- post content -->
			<div class="blog__content mb-30 col-lg-8">
				<main class="site-main">

				<?php while ( have_posts() ) : the_post();
					if ( function_exists( 'deo_save_post_views' ) ) {
						deo_save_post_views( get_the_ID() );
					}

					get_template_part( 'template-parts/post/content-single', get_post_format() );
				endwhile; ?>

				</main>
			</div> <!-- post content -->

			<?php
				// Sidebar
				if ( 'fullwidth' !== deo_layout_type( 'blog' ) ) {
					deo_sidebar();
				}
			?>

		</div>
	</div>
</div> <!-- .main-content -->

<?php do_action( 'neotech_single_entry_section_after' ); ?>

<?php get_footer(); ?>