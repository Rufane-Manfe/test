<?php
/**
 * Template parts.
 * @author  	 DeoThemes
 * @copyright  (c) Copyright by DeoThemes
 * @link       https://deothemes.com
 * @package 	 Neotech
 * @since 		 1.0.0
 */


add_action( 'neotech_single_entry_section_before', 'neotech_breadcrumbs' );
add_action( 'neotech_archive_section_before', 'neotech_breadcrumbs' );


/**
 * Breadcrumbs
 */
if ( ! function_exists( 'neotech_breadcrumbs' ) ) {
	function neotech_breadcrumbs() {

		if ( ! function_exists( 'bcn_display' ) ) {
			return;
		}

		if ( is_archive() && get_theme_mod( 'deo_breadcrumbs_archive_show', true ) ) {
			neotech_breadcrumbs_markup();
		}

		if ( is_single() && get_theme_mod( 'deo_breadcrumbs_blog_show', true ) ) {
			neotech_breadcrumbs_markup();
		}

	}
}


/**
 * Breadcrumbs
 */
if ( ! function_exists( 'neotech_breadcrumbs_markup' ) ) {
	function neotech_breadcrumbs_markup() {
		?>
		<div class="breadcrumbs-wrap">
			<div class="container">
				<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
					<?php bcn_display(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}