<?php defined('ABSPATH') OR die('restricted access'); ?>

<!-- Navigation -->
<header class="nav">

	<div class="nav__holder <?php if( get_theme_mod( 'deo_sticky_nav_show', true ) ) { echo esc_attr( 'nav--sticky' ); } ?>">
		<div class="container relative">
			<div class="nav__flex-parent flex-parent">

				<!-- Mobile Menu Button -->
				<button class="nav-icon-toggle" id="nav-icon-toggle" aria-label="Open mobile menu">
					<span class="nav-icon-toggle__box">
						<span class="nav-icon-toggle__inner"></span>
					</span>
				</button> <!-- end mobile menu button -->

				<!-- Logo -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
					<?php if( get_theme_mod( 'deo_logo_image_upload' ) ) : ?>
						<img src="<?php echo esc_attr( get_theme_mod( 'deo_logo_image_upload' ) ) ?>" srcset="<?php echo esc_attr( get_theme_mod( 'deo_logo_image_upload' ) ) . ' 1x' ?>, <?php echo esc_attr( get_theme_mod( 'deo_logo_retina_image_upload' ) ) . ' 2x' ?>" class="logo__img" alt="<?php bloginfo( 'name' ) ?>">
					<?php else : ?>
						<span class="site-title"><?php bloginfo( 'name' ) ?></span>
					<?php endif; ?>
				</a>

				<!-- Nav-wrap -->
				<nav class="flex-child nav__wrap d-none d-lg-block">
					<?php
					if ( has_nav_menu('main-menu') ) {
						wp_nav_menu( array(
							'theme_location'  => 'main-menu',
							'fallback_cb'     => '__return_false',
							'container'       => false,
							'menu_class'      => 'nav__menu',
							'walker'          => new Deo_Walker_Nav_Primary()
						) );
					}
					?>
				</nav> <!-- end nav-wrap -->

				<!-- Nav Right -->
				<div class="nav__right nav--align-right d-none d-lg-flex">

					<?php
						if ( get_theme_mod( 'deo_nav_socials_show', 1 )
							&& function_exists( 'deo_render_social_icons' ) ) :
					?>
						<!-- Socials -->
						<div class="nav__right-item socials socials--nobase nav__socials">
							<?php echo deo_render_social_icons(); ?>
						</div>
					<?php
					endif; ?>

					<?php if ( is_active_sidebar( 'deo-newsletter-popup' ) ) : ?>
						<!-- Subscribe -->
						<div class="nav__right-item">
							<a href="#" class="nav__subscribe" data-toggle="modal" data-target="#subscribe-modal"><?php esc_html_e( 'Subscribe', 'neotech' ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'deo_nav_search_show', true ) ) :
						$unique_id = uniqid( 'search-form-' );
					?>
						<!-- Search -->
						<div class="nav__right-item nav__search">
							<a href="#" class="nav__search-trigger" id="nav__search-trigger">
								<i class="ui-search nav__search-trigger-icon"></i>
							</a>
							<div class="nav__search-box" id="nav__search-box">
								<form role="search" method="get" class="nav__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="nav__search-input" placeholder="<?php esc_attr_e( 'Search an article', 'neotech' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
									<button type="submit" class="nav__search-button btn btn-md btn-color btn-button">
										<i class="ui-search nav__search-icon"></i>
									</button>
								</form>
							</div>
						</div>
					<?php endif; ?>

				</div> <!-- end nav right -->

			</div> <!-- end flex-parent -->
		</div> <!-- end container -->
	</div>
</header> <!-- end navigation -->