<?php
/**
 * The template for displaying search results pages.
 *
 * @package Neotech
 */

get_header(); ?>

<div class="section-wrap search-results-section pb-60">
	<div class="container">
		<main class="site-main">

			<!-- Page Title -->
			<h1 class="page-title">
				<?php printf( esc_html__( 'Search Results for: %s', 'neotech' ), '<span>' . get_search_query() . '</span>' ); ?>
			</h1>

			<!-- Grid Layout -->
			<?php get_template_part( 'template-parts/post/grid-content-3-columns' ); ?>

			<!-- Pagination -->
			<?php deo_paging_nav(); ?>

		</main>
	</div> <!-- .container -->
</div>
<?php get_footer(); ?>