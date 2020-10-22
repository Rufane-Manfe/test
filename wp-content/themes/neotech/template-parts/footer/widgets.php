<?php defined('ABSPATH') OR die('restricted access');

$footer_bottom_text = get_theme_mod( 'deo_footer_bottom_text', sprintf(
	esc_html__( 'Neotech, made by %1$sDeoThemes%2$s' , 'neotech' ),
	'<a href="https://deothemes.com">',
	'</a>'
) );

?>

<!-- Footer -->
<footer class="footer">
	<div class="container">
		<?php if( get_theme_mod( 'deo_footer_widgets_show', true ) ) : ?>

			<?php if ( is_active_sidebar( 'deo-footer-col-1' ) || is_active_sidebar( 'deo-footer-col-2' ) || is_active_sidebar( 'deo-footer-col-3' ) || is_active_sidebar( 'deo-footer-col-4' ) ) : ?>
				<div class="footer__widgets">
					<div class="row">

						<!-- 4 Columns -->
						<?php if ( get_theme_mod( 'deo_footer_columns', 'four-col' ) == 'four-col' ) : ?>

							<?php if(is_active_sidebar( 'deo-footer-col-1' ) ) : ?>
								<div class="col-lg-3 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-1' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-2' )) : ?>
								<div class="col-lg-3 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-2' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-3' )) : ?>
								<div class="col-lg-3 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-3' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-4' )) : ?>
								<div class="col-lg-3 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-4' ); ?>
								</div>
							<?php endif; ?>

						<?php endif; ?>

						<!-- 3 Columns -->
						<?php if ( get_theme_mod( 'deo_footer_columns', 'four-col' ) == 'three-col' ) : ?>

							<?php if(is_active_sidebar( 'deo-footer-col-1' )) : ?>
								<div class="col-lg-4 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-1' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-2' )) : ?>
								<div class="col-lg-5 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-2' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-3' )) : ?>
								<div class="col-lg-3 col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-3' ); ?>
								</div>
							<?php endif; ?>

						<?php endif; ?>

						<!-- 2 Columns -->
						<?php if ( get_theme_mod( 'deo_footer_columns', 'four-col' ) == 'two-col' ) : ?>

							<?php if(is_active_sidebar( 'deo-footer-col-1' )) : ?>
								<div class="col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-1' ); ?>
								</div>
							<?php endif; ?>

							<?php if(is_active_sidebar( 'deo-footer-col-2' )) : ?>
								<div class="col-md-6">
									<?php dynamic_sidebar( 'deo-footer-col-2' ); ?>
								</div>
							<?php endif; ?>

						<?php endif; ?>

						<!-- 1 Column -->
						<?php if ( get_theme_mod( 'deo_footer_columns', 'four-col' ) == 'one-col' ) : ?>

							<?php if(is_active_sidebar( 'deo-footer-col-1' )) : ?>
								<div class="col-md-12">
									<?php dynamic_sidebar( 'deo-footer-col-1' ); ?>
								</div>
							<?php endif; ?>

						<?php endif; ?>
					</div>
				</div> <!-- end footer widgets -->
			<?php endif; ?>

		<?php endif; ?> <!-- if footer show -->
	</div> <!-- end container -->

	<?php if( get_theme_mod( 'deo_footer_bottom_show', true ) ) : ?>
		<div class="footer__bottom">
			<div class="container text-center">

				<?php if ( get_theme_mod( 'deo_footer_bottom_text', 'Made by DeoThemes' ) ) : ?>

					<span class="copyright">
						&copy; <?php echo date('Y') . ' '; ?>
						<?php echo wp_kses_post ( $footer_bottom_text ); ?>
					</span>

				<?php endif; ?>
			</div>
		</div> <!-- end footer bottom -->
	<?php endif; ?> <!-- if footer bottom show -->
</footer> <!-- end footer -->