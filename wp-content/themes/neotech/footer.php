<?php
/**
 * The template for displaying the footer.
 * @author  	 DeoThemes
 * @copyright  (c) Copyright by DeoThemes
 * @link       https://deothemes.com
 * @package 	 Estand
 * @since 		 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>

		<?php get_template_part( 'template-parts/footer/widgets' ); ?>

		<?php if ( is_active_sidebar( 'deo-newsletter-popup' ) ) : ?>

			<!-- Subscribe Modal -->
			<div class="modal fade subscribe-modal subscribe-popup-modal" id="subscribe-modal" tabindex="-1" role="dialog" aria-label="Subscribe Modal" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php dynamic_sidebar( 'deo-newsletter-popup' ); ?>
						</div>
					</div>
				</div>
			</div> <!-- end subscribe modal -->

		<?php endif; ?>
	</div> <!-- #main-container -->

	<?php if ( get_theme_mod( 'deo_back_to_top_show', true ) ) : ?>
		<div id="back-to-top">
		  <a href="#top"><i class="ui-arrow-up"></i></a>
		</div>
	<?php endif; ?>

</div> <!-- .main-wrapper -->

<?php wp_footer(); ?>

</body>
</html>