<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    Deo_Core
 * @subpackage Deo_Core/includes
 * @version    1.0.0
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) )   exit; // Exit if accessed directly.

if ( ! class_exists( 'Deo_Core' ) ) {
	/**
	* The core plugin class.
	*
	* This is used to define internationalization, admin-specific hooks, and
	* public-facing site hooks.
	*/
	class Deo_Core
	{
		/**
		* The loader that's responsible for maintaining and registering all hooks that power
		* the plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      Deo_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
		*/
		protected $loader;

		/**
		* The unique identifier of this plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      string    $plugin_name    The string used to uniquely identify this plugin.
		*/
		protected $plugin_name;

		/**
		* The current version of the plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      string    $version    The current version of the plugin.
		*/
		protected $version;


		/**
		* Define the core functionality of the plugin.
		*
		* Load the dependencies, define the locale, and set the hooks for the admin area and
		* the public-facing side of the site.
		*
		* @since 1.0.0
		*/
		public function __construct() {

			if ( defined( 'DEO_CORE_VERSION' ) ) {
				$this->version = DEO_CORE_VERSION;
			} else {
				$this->version = '1.0.0';
			}

			$this->plugin_name = 'deo-core';

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}


		/**
		* Load the required dependencies for this plugin.
		*
		* Include the following files that make up the plugin:
		*
		* - Deocore_Loader. Orchestrates the hooks of the plugin.
		* - Deocore_i18n. Defines internationalization functionality.
		* - Deocore_Admin. Defines all hooks for the admin area.
		* - Deocore_Public. Defines all hooks for the public side of the site.
		*
		* Create an instance of the loader which will be used to register the hooks
		* with WordPress.
		*
		* @since    1.0.0
		* @access   private
		*/
		private function load_dependencies() {

			/**
			* The class responsible for orchestrating the actions and filters of the
			* core plugin.
			*/
			require_once DEO_CORE_PATH . 'includes/class-deo-core-loader.php';

			/**
			* The class responsible for defining internationalization functionality
			* of the plugin.
			*/
			require_once DEO_CORE_PATH . 'includes/class-deo-core-i18n.php';

			/**
			* The class responsible for defining all actions that occur in the admin area.
			*/
			require_once DEO_CORE_PATH . 'admin/class-deo-core-admin.php';

			/**
			* The class responsible for defining all actions that occur in the public-facing
			* side of the site.
			*/
			require_once DEO_CORE_PATH . 'public/class-deo-core-public.php';

			/**
			* The class responsible for all global functions.
			*/
			require_once DEO_CORE_PATH . 'includes/deo-core-global-functions.php';

			/**
			* Load Files
			*/

			// Widgets
			require_once( DEO_CORE_PATH . 'widgets/widget-about.php' );
			require_once( DEO_CORE_PATH . 'widgets/widget-popular-posts.php' );
			require_once( DEO_CORE_PATH . 'widgets/widget-socials.php' );
			require_once( DEO_CORE_PATH . 'widgets/widget-twitter.php' );
			require_once( DEO_CORE_PATH . 'widgets/widget-reviews.php' );

			// Metaboxes
			require_once( DEO_CORE_PATH . 'metaboxes/class-deo-metabox.php' );
			require_once( DEO_CORE_PATH . 'metaboxes/deo-metabox-init.php' );

			$this->loader = new Deo_Core_Loader();
		}


		/**
		* Define the locale for this plugin for internationalization.
		*
		* Uses the Deo_Core_i18n class in order to set the domain and to register the hook
		* with WordPress.
		*
		* @since    1.0.0
		* @access   private
		*/
		private function set_locale() {

			$plugin_i18n = new Deo_Core_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		* Register all of the hooks related to the admin area functionality
		* of the plugin.
		*
		* @since    1.0.0
		* @access   private
		*/
		private function define_admin_hooks() {

			$plugin_admin = new Deo_Core_Admin( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

			// Hook: Editor assets.
			$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'enqueue_block_editor_assets' );

		}

		/**
		* Register all of the hooks related to the public-facing functionality
		* of the plugin.
		*
		* @since    1.0.0
		* @access   private
		*/
		private function define_public_hooks() {

			$plugin_public = new Deo_Core_Public( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_filter( 'the_content', $plugin_public, 'shortcode_remove_paragraph' );

			// Hook: Frontend assets.
			$this->loader->add_action( 'enqueue_block_assets', $plugin_public, 'enqueue_block_assets' );

			// Shortcodes
			$this->loader->add_shortcode( 'socials', $plugin_public, 'shortcode_socials' );
			$this->loader->add_shortcode( 'button', $plugin_public, 'shortcode_button' );
			$this->loader->add_shortcode( 'alert', $plugin_public, 'shortcode_alert' );

			remove_action( 'wp_head', array( $this, 'adjacent_posts_rel_link_wp_head', 10 ) );

		}

		/**
		* Run the loader to execute all of the hooks with WordPress.
		*
		* @since    1.0.0
		*/
		public function run() {
			$this->loader->run();
		}


		/**
		* The name of the plugin used to uniquely identify it within the context of
		* WordPress and to define internationalization functionality.
		*
		* @since     1.0.0
		* @return    string    The name of the plugin.
		*/
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		* The reference to the class that orchestrates the hooks with the plugin.
		*
		* @since     1.0.0
		* @return    Deo_Core_Loader    Orchestrates the hooks of the plugin.
		*/
		public function get_loader() {
			return $this->loader;
		}

		/**
		* Retrieve the version number of the plugin.
		*
		* @since     1.0.0
		* @return    string    The version number of the plugin.
		*/
		public function get_version() {
			return $this->version;
		}


	}
}