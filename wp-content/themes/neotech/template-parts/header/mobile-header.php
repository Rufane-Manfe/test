<?php defined('ABSPATH') OR die('restricted access'); ?>

<!-- Mobile Sidenav -->
<header class="sidenav" id="sidenav">

	<?php if ( get_theme_mod( 'deo_nav_search_show', true ) ) :
		$unique_id = uniqid( 'search-form-' );
	?>
		<!-- Search -->
		<div class="sidenav__search-mobile">
			<form role="search" method="get" class="sidenav__search-mobile-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="sidenav__search-mobile-input" placeholder="<?php esc_attr_e( 'Search an article', 'neotech' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
				<button type="submit" class="sidenav__search-mobile-submit">
					<i class="ui-search"></i>
				</button>
			</form>
		</div>
	<?php endif; ?>

	<nav>
		<?php
		if ( has_nav_menu('main-menu') ) {
			wp_nav_menu( array(
				'theme_location'  => 'main-menu',
				'fallback_cb'     => '__return_false',
				'container'       => false,
				'menu_class'      => 'sidenav__menu',
				'walker'          => new Deo_Walker_Sidenav_Menu()
			) );
		}
		?>
	</nav>

	<?php
		if ( get_theme_mod( 'deo_nav_socials_show', 1 )
			&& function_exists( 'deo_render_social_icons' ) ) :
	?>
		<!-- Socials -->
		<div class="socials sidenav__socials">
			<?php echo deo_render_social_icons(); ?>
		</div>
	<?php
	endif; ?>

</header> <!-- end mobile sidenav -->