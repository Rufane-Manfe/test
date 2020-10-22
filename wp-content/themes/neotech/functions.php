<?php defined('ABSPATH') OR die('restricted access');

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

// Constants
define('DEOTHEMEDIR', get_template_directory() );
define('DEOTHEMEURI', get_template_directory_uri() );

require DEOTHEMEDIR . '/includes/theme-setup.php';
require DEOTHEMEDIR . '/includes/class-nav-walker.php';
require DEOTHEMEDIR . '/includes/class-sidenav-walker.php';
require DEOTHEMEDIR . '/includes/class-comments-walker.php';

if ( is_admin() ) {
	require get_parent_theme_file_path( '/includes/tgm-plugin-activation/plugins.php' );
}

require DEOTHEMEDIR . '/includes/theme-functions.php';
require DEOTHEMEDIR . '/includes/template-tags.php';
require DEOTHEMEDIR . '/includes/template-parts.php';
require DEOTHEMEDIR . '/includes/customizer.php';

// Theme scripts and styles
function deo_theme_styles() {

	if ( is_admin() ) {
		return null;
	}

	//wp_enqueue_style( 'bootstrap', DEOTHEMEURI . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'deo-font-icons', DEOTHEMEURI . '/assets/css/font-icons.css' );
	if ( get_theme_mod( 'deo_cookies_bar_show', false ) ) {
		wp_enqueue_style( 'cookieconsent', DEOTHEMEURI . '/assets/css/cookieconsent.min.css' );
	}
	wp_enqueue_style( 'deo-styles', get_stylesheet_uri(), array( 'deo-font-icons' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Fonts
	if ( ! class_exists( 'Kirki' ) ) {
		wp_enqueue_style( 'deo-google-fonts', '//fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,400i,700' );
	}

	wp_dequeue_style( 'wp-editor-font' );
	wp_deregister_style( 'wp-editor-font' );
	
}

add_action( 'wp_enqueue_scripts', 'deo_theme_styles' );


/**
* Load Gutenberg backend styles.
*/
function deo_gutenberg_assets() {
	wp_enqueue_style( 'deo-gutenberg-editor-styles', get_theme_file_uri( '/assets/css/gutenberg-editor-style.css' ), false );
	if ( ! class_exists( 'Kirki' ) ) {
		wp_enqueue_style( 'deo-gutenberg-editor-google-fonts', '//fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,400i,700' );
	}
}
add_action( 'enqueue_block_editor_assets', 'deo_gutenberg_assets' );


function deo_theme_js() {
	wp_enqueue_script( 'bootstrap', DEOTHEMEURI . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'flickity', DEOTHEMEURI . '/assets/js/flickity.pkgd.min.js', array('jquery', 'bootstrap' ), '', true );
	wp_enqueue_script( 'masonry' );
	if ( get_theme_mod( 'deo_sticky_sidebar', true ) ) {
		wp_enqueue_script( 'jquery-sticky-kit', DEOTHEMEURI . '/assets/js/sticky-kit.min.js', array('jquery', 'bootstrap' ), '', true );
	}
	wp_enqueue_script( 'lazysizes', DEOTHEMEURI . '/assets/js/lazysizes.min.js', array(), '5.2.2', true );
	wp_enqueue_script( 'modernizr', DEOTHEMEURI . '/assets/js/modernizr.min.js', array( 'jquery', 'bootstrap' ), '', true );
	wp_register_script( 'deo-scripts', DEOTHEMEURI . '/assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'deo-scripts' );

	// Cookie notification bar
	if ( get_theme_mod( 'deo_cookies_bar_show', false ) ) {
		wp_enqueue_script( 'cookieconsent', DEOTHEMEURI . '/assets/js/cookieconsent.min.js', array( 'jquery' ), '3.1.0', true );

		wp_register_script( 'deo-cookie-consent', DEOTHEMEURI . '/assets/js/cookies.js', array( 'cookieconsent' ), '1.0.0', true );
		$cookies_data = array(
			'message' => get_theme_mod( 'deo_cookies_message', esc_html__( 'We are using cookies to personalize content and ads to make our site easier for you to use.', 'neotech' ) ),
			'dismiss' => get_theme_mod( 'deo_cookies_button', esc_html__( 'Agree', 'neotech' ) ),
			'link' => get_theme_mod( 'deo_cookies_learn_more_text', esc_html__( 'Learn More', 'neotech' ) ),
			'href' => get_theme_mod( 'deo_cookies_learn_more_url', esc_url( '//cookiesandyou.com' ) ),			
		); 
		wp_localize_script( 'deo-cookie-consent', 'cookies', $cookies_data );
		wp_enqueue_script( 'deo-cookie-consent' );		
	}

	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
}

add_action( 'wp_enqueue_scripts', 'deo_theme_js' );


/**
 * Enqueue scripts and styles for WP Customizer.
 */
function deo_customizer_enqueue_scripts() {
	wp_enqueue_style( 'deo-customizer-styles', DEOTHEMEURI . '/assets/css/customizer/customizer.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'deo_customizer_enqueue_scripts' );