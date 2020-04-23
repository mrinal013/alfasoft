<?php

use includes\Wp_Admin_Vue;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              mrinalbd.com
 * @since             1.0.0
 * @package           Wp_Admin_Vue
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Dashboard with Vue
 * Plugin URI:        mrinalbd.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mrinal Haque
 * Author URI:        mrinalbd.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-admin-vue
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_ADMIN_VUE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-admin-vue-activator.php
 */
function activate_wp_admin_vue() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-admin-vue-activator.php';
	Wp_Admin_Vue_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-admin-vue-deactivator.php
 */
function deactivate_wp_admin_vue() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-admin-vue-deactivator.php';
	Wp_Admin_Vue_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_admin_vue' );
register_deactivation_hook( __FILE__, 'deactivate_wp_admin_vue' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// require plugin_dir_path( __FILE__ ) . 'includes/class-wp-admin-vue.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_admin_vue() {

	$plugin = new Wp_Admin_Vue();
	$plugin->run();

}
// run_wp_admin_vue();

class Main_Plugin_Class {
	public function __construct() {
		$this->wp_admin_vue_autoload();

		( new Wp_Admin_Vue() )->run();
	}

	public function wp_admin_vue_autoload() {
		spl_autoload_register( function( $class ) {
			$file_name = plugin_dir_path( __FILE__ ) . str_replace( '\\', DIRECTORY_SEPARATOR, substr_replace( str_replace( '_', '-', strtolower( $class ) ), 'class-', strpos( $class, '\\', 0 ) + 1, 0 ) ) . '.php';

			if( file_exists( $file_name ) ) {
				require $file_name;
			}

		} );
	}
}

new Main_Plugin_Class();
