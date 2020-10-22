<?php
/**
 * Plugin Name:       Deo Core
 * Description:       Core functions for our WordPress theme
 * Version:           1.1.12
 * Author:            DeoThemes
 * Author URI:        https://deothemes.com
 * Plugin URI:        https://deothemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       deo-core
 * Domain Path:       /languages
 *
 * @link https://deothemes.com
 * @since 1.0.0
 * @package Deo_Core
*/

if ( ! defined( 'ABSPATH' ) )   exit; // Exit if accessed directly.

define( 'DEO_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'DEO_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'DEO_CORE_VERSION', '1.1.12' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-deo-core-activator.php
 */
function activate_deo_core() {
    require_once DEO_CORE_PATH . 'includes/class-deo-core-activator.php';
    Deo_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deo-core-deactivator.php
 */
function deactivate_deo_core() {
    require_once DEO_CORE_PATH . 'includes/class-deo-core-deactivator.php';
    Deo_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_deo_core' );
register_deactivation_hook( __FILE__, 'deactivate_deo_core' );


/**
 * The core plugin class
 */
require_once( DEO_CORE_PATH . '/includes/class-deo-core.php' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Deocore() {
    $Deo_Core = new Deo_Core();
    $Deo_Core->run();
}
run_Deocore();