<?php
/**
 * The header for this theme.
 * @author  	 DeoThemes
 * @copyright  (c) Copyright by DeoThemes
 * @link       https://deothemes.com
 * @package 	 Neotech
 * @since 		 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage" >

	<?php wp_body_open(); ?>

	<!-- Preloader -->
	<?php if ( get_theme_mod( 'deo_preloader_settings', false ) ) : ?>
		<div class="loader-mask">
			<div class="loader">
			  <div></div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Bg Overlay -->
	<div class="content-overlay"></div>

	<?php get_template_part( 'template-parts/header/mobile-header' ); ?>

	<div class="main-wrapper" id="content">

		<?php get_template_part( 'template-parts/header/standard-header' ); ?>

		<div class="main-container" id="main-container">