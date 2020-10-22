<?php defined('ABSPATH') OR die('restricted access');

/**
 * neotech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package neotech
 */

if ( ! function_exists( 'neotech_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function neotech_setup() {

		load_theme_textdomain( 'neotech', DEOTHEMEDIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(array(
			'main-menu'           => esc_html__( 'Main Menu', 'neotech' ),
			'footer'              => esc_html__( 'Footer Menu', 'neotech' ),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'post-formats', array(
			'video',
			'audio',
			'gallery'
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'deo_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( "custom-header" );
		
		// Gutenberg
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_editor_style();


		add_theme_support( 'editor-color-palette', array(
			array(
				'name' => esc_html__( 'vivid-red', 'neotech' ),
				'slug' => 'vivid-red',
				'color' => '#E12A21',
			),
			array(
				'name' => esc_html__( 'light-orange', 'neotech' ),
				'slug' => 'light-orange',
				'color' => '#F8875F',
			),
			
			array(
				'name' => esc_html__( 'vivid-blue', 'neotech' ),
				'slug' => 'vivid-blue',
				'color' => '#4C86E7',
			),
			array(
				'name' => esc_html__( 'turquoise', 'neotech' ),
				'slug' => 'turquoise',
				'color' => '#30dca5',
			),
			array(
				'name' => esc_html__( 'light-blue', 'neotech' ),
				'slug' => 'light-blue',
				'color' => '#f4f6f6',
			),
			array(
				'name' => esc_html__( 'dark-blue', 'neotech' ),
				'slug' => 'dark-blue',
				'color' => '#041726',
			),

		) );

		// Set size of thumbnails
		add_image_size( 'neotech-related-thumb', 230, 164, true );
		add_image_size( 'neotech-small-tab-post', 77, 62, true );
		add_image_size( 'neotech-small-grid-widget-thumb', 125, 94, true );
		add_image_size( 'neotech-post-list-thumb', 255, 200, true );
		add_image_size( 'neotech-thumb-single-post', 730, 412, true );
		add_image_size( 'neotech-post-grid-cat-thumb', 350, 250, true );
		add_image_size( 'neotech-popular-posts-thumb', 65, 60, true );
		add_image_size( 'neotech-featured-slider', 206, 203, true );
		add_image_size( 'neotech-carousel-vertical-thumb', 255, 290, true );
	}

endif;

add_action( 'after_setup_theme', 'neotech_setup' );



/*
 * Register theme sidebars.
 */
add_action( 'widgets_init', function() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'neotech' ),
		'id'            => 'deo-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Newsletter Popup', 'neotech' ),
		'id'            => 'deo-newsletter-popup',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'neotech' ),
		'id'            => 'deo-footer-col-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'neotech' ),
		'id'            => 'deo-footer-col-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'neotech' ),
		'id'            => 'deo-footer-col-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'neotech' ),
		'id'            => 'deo-footer-col-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
});


/*
 * Update Elementor Defaults
 */
if ( 1 != get_option( 'deo_elementor_defaults', 0 ) ) {
	add_option( 'deo_elementor_defaults', 0 );
}

function deo_update_elementor_defaults() {
	if ( 1 != get_option( 'deo_elementor_defaults' ) ) {
		update_option( 'elementor_scheme_color', array(
			1 => '#E12A21',
			2 => '#3A444D',
			3 => '#49545E',
			4 => '#F8875F'
		) );

		update_option( 'elementor_scheme_color-picker', array(
			1 => '#E12A21',
			2 => '#3A444D',
			3 => '#49545E',
			4 => '#F8875F',
			5 => '#919BA3',
			6 => '#041726',
			7 => '#000000',
			8 => '#FFFFFF'
		) );
		
		update_option( 'elementor_container_width', 1230 );
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'deo_elementor_defaults', 1 );
	}
}
add_action( 'init', 'deo_update_elementor_defaults' );


/*
 * Disable redirect after Elementor install
 */
add_action( 'admin_init', function() {
	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
	}
}, 1 );


/*
 * Disable Kirki telemetry
 */
add_filter( 'kirki_telemetry', '__return_false' );


/*
 * Demo Import
 */
function deo_ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo Import 1',
			'categories'                   => array( 'Category 1', 'Category 2' ),
			'local_import_file'            => trailingslashit( DEOTHEMEDIR ) . 'includes/demo-import/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( DEOTHEMEDIR ) . 'includes/demo-import/widgets.wie',
			'local_import_customizer_file' => trailingslashit( DEOTHEMEDIR ) . 'includes/demo-import/customizer.dat'
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'deo_ocdi_import_files' );


/**
* Assign menus and front page after demo import
*
* @param array $selected_import array with demo import data
*/
function deo_ocdi_after_import( $selected_import ) {
	// Assign menus to their locations.
	$primary_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'main-menu' => $primary_menu->term_id,
			'footer' => $footer_menu->term_id,
		)
	);

	// Assign front page based on demo import
	switch ( $selected_import['import_file_name'] ) {

		case 'Demo Import 1':
			$front_page_id = get_page_by_title( 'Home' );
			// $blog_page_id  = get_page_by_title( 'Blog' );
			update_option( 'page_on_front', $front_page_id->ID );
			break;

		default:
			break;
	}

	update_option( 'show_on_front', 'page' );
	// update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'deo_ocdi_after_import' );