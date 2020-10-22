<?php
/**
 * The template for displaying archive pages.
 *
 * @package Neotech
 */

get_header();

$archive_title    	 = get_the_archive_title();
$archive_description = get_the_archive_description();

do_action( 'neotech_archive_section_before' ); ?>

<div class="section-wrap archive-section pb-30 pt-40">
	<div class="container">
		<div class="row">

			<div class="blog__content mb-30 <?php if ( 'fullwidth' !== deo_layout_type( 'archives' ) ) { echo esc_attr( 'col-lg-8' ); } else { echo esc_attr( 'col-lg-12' ); } ?>">
				<main class="site-main">			

					<?php if ( is_author() ) : ?>
						<?php echo deo_author_box(); ?>
					<?php endif; ?>

					<?php if ( $archive_title || $archive_description ) : ?>

						<?php if ( $archive_title ) : ?>
							<h1 class="page-title">

								<?php
									if ( is_category() || is_tag() ) {
										single_cat_title();				
									
									} elseif ( is_author() ) {
										printf( esc_html__( 'All Posts by %s', 'neotech' ), '<span class="vcard">' . get_the_author() . '</span>' );

									} else {
										echo wp_kses_post( $archive_title );
									}
								?>

							</h1>
						<?php endif; ?>

						<?php if ( $archive_description && ! is_author() ) : ?>
							<div class="page-title__description"><?php echo wp_kses_post( wpautop( $archive_description ) ); ?></div>
						<?php endif; ?>

					<?php endif; ?>

					<!-- Grid Layout -->
					<?php get_template_part( 'template-parts/post/grid-content' ); ?>

					<!-- Pagination -->
					<?php deo_paging_nav(); ?>

				</main>
			</div> <!-- .blog__content -->

			<?php
				// Sidebar
				if ( 'fullwidth' !== deo_layout_type( 'archives' ) ) {
					deo_sidebar();
				}
			?>
		</div>
	</div> <!-- .container -->
</div>

<?php do_action( 'neotech_archive_section_after' ); ?>

<?php get_footer();  ?>