<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://deothemes.com
 * @since      1.0.0
 *
 * @package    Deo_Core
 * @subpackage Deo_Core/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Deo_Core
 * @subpackage Deo_Core/public
 * @author     DeoThemes
 */
class Deo_Core_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Enqueue Gutenberg block assets for both frontend + backend.
	 *
	 * @uses {wp-editor} for WP editor styles.
	 * @since 1.0.0
	 */
	public function enqueue_block_assets() {
		// Styles.
		wp_enqueue_style(
			$this->plugin_name . '-block-style',
			plugins_url( 'blocks/blocks.style.build.css', dirname( __FILE__ ) ),
			array( 'wp-editor' )
		);
	}


	/**
	* Removes empty paragraph from shortcode
	*/
	public function shortcode_remove_paragraph( $content ) {
		// array of custom shortcodes requiring the fix 
		$block = join("|",array("col","shortcode2","shortcode3"));
		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
		return $rep;
	}


	/**
	* Shortcode Socials
	*/
	public function shortcode_socials( $atts, $content = null ) {

		$atts = shortcode_atts(
			array(),
			$atts,
			'socials'
		);

		return deo_render_social_icons();

	}

	/**
	* Shortcode Button
	*/
	public function shortcode_button( $atts, $content = null ) {

		$atts = shortcode_atts(
			array(
				'color'  => 'btn--color',
				'size'   => 'btn--lg',
				'href'   => esc_url( '#' ),
				'target' => ''
			),
			$atts,
			'button'
		);

		$target = ( ! empty( $atts['target'] ) ) ? ' target="' . esc_attr( $atts['target'] ) . '"' : '';

		// Output
		$button = '<a href="' . esc_url( $atts['href'] ) . '" class="btn ' . esc_attr( $atts['size'] ) . ' ' . esc_attr( $atts['color'] ) . '"' . $target . '>';
			$button .= '<span>' . $content . '</span>';
		$button .= '</a>';

		return $button;

	}


	/**
	* Shortcode Alert
	*/
	public function shortcode_alert( $atts, $content = null ) {

		$atts = shortcode_atts(
			array(
				'type' 				 => 'info',
				'dismissible' => '',
				'target'			 => ''
			),
			$atts,
			'alert'
		);

		$alert = '<div class="alert ' . 'alert-' . esc_attr( $atts['type'] ) . ( ! empty( $atts['dismissible'] ) ? esc_attr( ' alert-dismissible fade show' ) : '' ) . '">';

			if ( ! empty( $atts['dismissible'] ) ) {
				$alert .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
			}
			
			$alert .= '<span>' . $content . '</span>';
		$alert .= '</div>';

		return $alert;

	}

}