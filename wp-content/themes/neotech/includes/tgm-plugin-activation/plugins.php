<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Neotech for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */

require_once get_template_directory() . '/includes/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'deo_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function deo_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'      => 'Kirki',
			'slug'      => 'kirki',
			'required'  => true,
		),

		array(
			'name'             => 'Deo Core',
			'slug'             => 'deo-core',
			'source'           => get_template_directory() . '/includes/plugins/deo-core.zip',
			'required'         => true,
			'version'          => '1.1.12',
			'force_activation' => false,
		),

		array(
			'name'             => 'Deo Elementor',
			'slug'             => 'deo-elementor',
			'source'           => get_template_directory() . '/includes/plugins/deo-elementor.zip',
			'required'         => true,
			'version'          => '1.3.4',
			'force_activation' => false,
		),

		array(
			'name'             => 'Envato Market',
			'slug'             => 'envato-market',
			'source'           => get_template_directory() . '/includes/plugins/envato-market.zip',
			'required'         => false,
			'version'          => '2.0.3',
			'force_activation' => false,
		),

		array(
			'name'          => 'Elementor',
			'slug'          => 'elementor',
			'required'  => true,
		),

		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		array(
			'name'      => 'MailChimp for WordPress',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),

		array(
			'name'      => 'One Click Demo Import',
			'slug'      => 'one-click-demo-import',
			'required'  => false,
		),

		array(
			'name'      => 'Breadcrumb NavXT',
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
		),

		array(
			'name'      => 'WP Review',
			'slug'      => 'wp-review',
			'required'  => false,
		),

		array(
			'name'      => 'Read Meter – Reading Time & Progress Bar',
			'slug'      => 'read-meter',
			'required'  => false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',

		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'neotech' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'neotech' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'neotech' ),
			'updating'                        => esc_html__( 'Updating Plugin: %s', 'neotech' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'neotech' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'neotech' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'neotech' ),
			'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'neotech' ),
			'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'neotech' ),
			'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'neotech' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'neotech' ),
			'dismiss'                         => esc_html__( 'Dismiss this notice', 'neotech' ),
			'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'neotech' ),
			'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'neotech' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}