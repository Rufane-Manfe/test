<?php
/**
 * The main template file.
 * @author  	 DeoThemes
 * @copyright  (c) Copyright by DeoThemes
 * @link       https://deothemes.com
 * @package 	 Neotech
 * @since 		 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

get_header();
?>

<div class="section-wrap blog-section pb-20">
	<div class="container">
		<div class="row">

			<div class="blog__content mb-30 <?php if ( 'fullwidth' !== deo_layout_type( 'blog' ) ) { echo esc_attr( 'col-lg-8' ); } else { echo esc_attr( 'col-lg-12' ); } ?>">
				<main class="site-main">

					<!-- Grid Layout -->
					<?php get_template_part( 'template-parts/post/grid-content' ); ?>

					<!-- Pagination -->
					<?php deo_paging_nav(); ?>

				</main>
			</div> <!-- .blog__content -->

			<?php
				// Sidebar
				if ( 'fullwidth' !== deo_layout_type( 'blog' ) ) {
					deo_sidebar();
				}
			?>
		</div>
	</div>
</div>

<?php get_footer(); ?>