<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Neotech
 */

get_header();
?>

<div class="section-wrap page-404-section">
	<div class="container text-center">
		<span class="error404__number"><?php esc_html_e( '404', 'neotech' ) ?></span>
		<div class="row justify-content-center">

			<div class="col-lg-6">
				<main class="site-main">
					<h1 class="entry-title"><?php esc_html_e('Page not found', 'neotech') ?></h1>

					<p class="mb-20"><?php esc_html_e('We\'re sorry, but the page you were looking for doesn\'t exist. Perhaps searching can help.', 'neotech') ?></p>

					<!-- Search form -->
					<?php get_search_form(); ?>
				</main>
			</div>

		</div>
	</div>
</div>

<?php get_footer(); ?>