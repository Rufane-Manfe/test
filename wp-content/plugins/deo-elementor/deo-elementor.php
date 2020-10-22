<?php
/**
 * Plugin Name: Deo Elementor
 * Description: Additional widgets for Neotech WordPress theme.
 * Plugin URI:  https://deothemes.com/
 * Version:     1.3.4
 * Author:      DeoThemes
 * Author URI:  https://deothemes.com/
 * Text Domain: deo-elementor
 */

namespace DeoThemes;

define( 'DEO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'DEO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'ABSPATH' ) )   exit; // Exit if accessed directly.

/**
 * Main Deo Elementor Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Deo_Elementor_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.3.4';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Deo_Elementor_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Deo_Elementor_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'deo-elementor' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add the widget category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		// Register assets
		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_scripts' ] );

		// Register widgets
		add_action( 'init', [ $this, 'init_widgets' ] );

		add_action( 'wp_ajax_nopriv_deo_widget_ajax_data', [ $this, 'deo_widget_ajax_data' ] );
		add_action( 'wp_ajax_deo_widget_ajax_data', [ $this, 'deo_widget_ajax_data' ] );

		add_action( 'wp_ajax_nopriv_deo_widget_load_more', [ $this, 'deo_widget_load_more' ] );
		add_action( 'wp_ajax_deo_widget_load_more', [ $this, 'deo_widget_load_more' ] );
	}

	/**
	* Add Elementor Widget Categories
	*
	* @since 1.0.0
	*
	* @access public
	*/
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'deothemes-widgets',
			[
				'title' => __( 'DeoThemes Widgets', 'deo-elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'deo-elementor' ),
			'<strong>' . esc_html__( 'Deo Elementor Extension', 'deo-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'deo-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'deo-elementor' ),
			'<strong>' . esc_html__( 'Deo Elementor', 'deo-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'deo-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'deo-elementor' ),
			'<strong>' . esc_html__( 'Deo Elementor', 'deo-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'deo-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	* Init Widgets
	*
	* Include widgets files and register them
	*
	* @since 1.0.0
	*
	* @access public
	*/
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/deo-widget-tabs-post.php' );
		require_once( __DIR__ . '/widgets/deo-widget-posts-by-filter.php' );
		require_once( __DIR__ . '/widgets/deo-widget-posts-grid.php' );
		require_once( __DIR__ . '/widgets/deo-widget-posts-list.php' );
		require_once( __DIR__ . '/widgets/deo-widget-videos-playlist.php' );
		require_once( __DIR__ . '/widgets/deo-widget-posts-carousel.php' );
		require_once( __DIR__ . '/widgets/deo-widget-featured-slider.php' );
		require_once( __DIR__ . '/widgets/deo-widget-thumb-post.php' );
		require_once( __DIR__ . '/widgets/deo-widget-posts-by-categories.php' );
		require_once( __DIR__ . '/widgets/deo-widget-videos-grid.php' );
		require_once( __DIR__ . '/widgets/deo-widget-masonry-post.php' );
		require_once( __DIR__ . '/widgets/deo-widget-newsletter.php' );
		require_once( __DIR__ . '/widgets/deo-widget-reviews.php' );
		require_once( __DIR__ . '/widgets/deo-widget-breadcrumbs.php' );

		// Include Ajax Files
		require_once( __DIR__ . '/widgets/ajax/deo-ajax-posts-list.php' );
		//require_once( __DIR__ . '/widgets/ajax/deo-ajax-posts-reviews.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Tabs_Post );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Posts_By_Filter );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Posts_Grid );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Posts_List );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Videos_Playlist );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Posts_Carousel );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Featured_Slider );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Thumb_Post );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Posts_By_Categories );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Videos_Grid );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Masonry_Post );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Newsletter );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Reviews );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Deo_Widget_Breadcrumbs );
	}

	public function register_scripts() {
		wp_enqueue_style( 'deo-elementor-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
		wp_enqueue_script( 'deo-elementor-scripts', plugins_url( '/assets/js/scripts.js', __FILE__ ), [ 'jquery' ], true );

		wp_localize_script( 'deo-elementor-scripts', 'deo_vars', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce( 'deo_ajax_nonce' ),
		));
	}

	public function deo_widget_ajax_data() {

		$param                    = array();
		$data_response            = array();
		$data_response['content'] = '';

		if ( ! empty( $_POST['data'] ) ) {
			$param = self::deo_validate_field( $_POST['data'] );
		}

		$query = self::deo_query_args( $param );

		if ( ! empty( $query->max_num_pages ) ) {
			$data_response['block_page_max'] = $query->max_num_pages;
		}

		// Get post data
		$data_response['content'] = self::deo_render_filter_posts( $query, $param );

		wp_reset_postdata();

		die( json_encode( $data_response ) );
	}


	public function deo_widget_load_more() {

		check_ajax_referer( 'deo_ajax_nonce', 'security' );

		$param = array();

		if ( ! empty( $_POST['data'] ) ) {
			$param = self::deo_validate_field( $_POST['data'] );
		}

		$query = self::deo_query_args( $param );

		// Get post data
		switch ( $param['widget_type'] ) {
			case 'deo-posts-list':
				deo_render_list_posts( $query, $param );
				break;

		}

		wp_reset_postdata();

		die();
	}


	// Posts by Filter
	public function deo_render_filter_posts( $data_query, $settings = array() ) {

		$output = '';
		$counter = 1;
		$total   = $data_query->post_count;

		while ( $data_query->have_posts() ) {
			$data_query->the_post();

			if ( $counter == 1 ) {
				$output .= self::small_post( $settings );
			} elseif ( $counter == 2 ) {
				$output .= self::large_post( $settings );
			} elseif ( $counter <= 5 ) {
				$output .= self::small_post( $settings );
			} elseif ( $counter == 6 ) {
				$output .= self::large_post( $settings );
			}

			if ( $counter >= 6 ) {
				$counter = 1;
			}

			$counter++;
		}

		return $output;
	}

	public function small_post( $settings ) {

		$image_url = '';

		if ( has_post_thumbnail() ) {
			$image_url = 'style="background-image: url(' . get_the_post_thumbnail_url( get_the_ID(), 'neotech-post-grid-cat-thumb' ) . ')"';
		}

		$output  = '<div class="col-lg-3 col-sm-6">';
		$output .= '<article class="entry">';
		$output .= '<div class="thumb-bg-holder entry__bg-img-holder" '. $image_url .'>';
		if ( 'yes' !== $settings['category_hide'] ) {
			$output .= '<div class="entry__meta-category-holder">' . neotech_meta_category() . '</div>';
		}
		$output .= '<a href="'. esc_url( get_the_permalink() ).'" title="'. esc_html( get_the_title() ) .'" class="thumb-url"></a>';
		$output .= '<div class="bottom-gradient"></div>';
		$output .= '</div>';
		$output .= '<div class="thumb-text-holder">';
		$output .= '<h2 class="thumb-entry-title">';
		$output .= '<a href="'. esc_url( get_the_permalink() ). '">'. esc_html( get_the_title() ).'</a>';
		$output .= '</h2>';
		$output .= '</div>';
		$output .= '</article>';
		$output .= '</div>';

		return $output;
	}

	public function large_post( $settings ) {

		$image_url = '';

		if ( has_post_thumbnail() ) {
			$image_url = 'style="background-image: url(' . get_the_post_thumbnail_url( get_the_ID(), 'neotech-post-grid-cat-thumb' ) . ')"';
		}

		$output  = '<div class="col-lg-6 col-sm-6">';
		$output .= '<article class="entry">';
		$output .= '<div class="thumb-bg-holder entry__bg-img-holder" '. $image_url .'>';
		if ( 'yes' !== $settings['category_hide'] ) {
			$output .= '<div class="entry__meta-category-holder">' . neotech_meta_category() . '</div>';
		}
		$output .= '<a href="'. esc_url( get_the_permalink() ).'" title="'. esc_html( get_the_title() ) .'" class="thumb-url"></a>';
		$output .= '<div class="bottom-gradient"></div>';
		$output .= '</div>';
		$output .= '<div class="thumb-text-holder">';
		$output .= '<h2 class="thumb-entry-title">';
		$output .= '<a href="'. esc_url( get_the_permalink() ). '">'. esc_html( get_the_title() ).'</a>';
		$output .= '</h2>';
		$output .= '</div>';
		$output .= '</article>';
		$output .= '</div>';

		return $output;
	}

	public function deo_validate_field( $data ) {

		if ( is_array( $data ) ) {
			foreach ( $data as $key => $val ) {
				$key           = sanitize_text_field( $key );
				$data[ $key ] = sanitize_text_field( $val );
			}
		} elseif ( is_string( $data ) ) {
			$data = sanitize_text_field( $data );
		} else {
			$data = '';
		}

		return $data;
	}


	public function deo_query_args( $query_args = array() ) {

		$args = wp_parse_args( $query_args, array(
			'post_status'         => array( 'publish' ),
			'ignore_sticky_posts' => true,
			'post_type'           => 'post',
		) );

		// How many posts
		if ( ! empty( $query_args['posts_per_page'] ) ) {
			$args['posts_per_page'] = $query_args['posts_per_page'];
		}

		// Category
		if ( ! empty( $query_args['category_id'] ) ) {
			$args['category_name'] = $query_args['category_id'];
		}

		// Order by
		if ( ! empty( $query_args['order_by'] ) ) {
			if ( 'meta_key' == $query_args['order_by'] ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = '_deo_post_views';
			} else {
				$args['orderby'] = $query_args['order_by'];
			}			
		}

		// Order
		if ( ! empty( $query_args['order'] ) ) {
			$args['order'] = $query_args['order'];
		}

		// Paged
		if ( ! empty( $query_args['page'] ) ) {
			$args['paged'] = $query_args['page'] + 1;
		}

		// Specific Posts by ID's
		if ( ! empty( $query_args['post_ids'] ) ) {
			$args['post__in'] = $post_ID;
		}

		// Prepare the cache key
		$cache_key = http_build_query( $args );

		// Check for the custom key in the theme group
		$custom_query = wp_cache_get( $cache_key, 'deo_cache_query' );

		// If nothing is found, build the object.
		if ( false === $custom_query ) {

			$custom_query = new \WP_Query( $args );

			if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {
				wp_cache_set( $cache_key, $custom_query, 'deo_cache_query' );
			}
		}

		return $custom_query;
	}    
}

Deo_Elementor_Extension::instance();