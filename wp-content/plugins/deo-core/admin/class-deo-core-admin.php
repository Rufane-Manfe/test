<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://deothemes.com
 * @since      1.0.0
 *
 * @package    Deo_Core
 * @subpackage Deo_Core/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Deo_Core
 * @subpackage Deo_Core/admin
 * @author     DeoThemes
 */
class Deo_Core_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Deo_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Deo_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @uses {wp-blocks} for block type registration & related functions.
	 * @uses {wp-element} for WP Element abstraction — structure of blocks.
	 * @uses {wp-i18n} to internationalize the block's text.
	 * @uses {wp-editor} for WP editor styles.
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script(
			$this->plugin_name . '-block-js',
			plugins_url( 'blocks/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			true
		);

		// Styles.
		wp_enqueue_style(
			$this->plugin_name . '-block-editor-style',
			plugins_url( 'blocks/blocks.editor.build.css', dirname( __FILE__ ) ),
			array( 'wp-edit-blocks' )
		);
	}	


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Deo_Core_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Deo_Core_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/widgets.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_media();

	}

}
