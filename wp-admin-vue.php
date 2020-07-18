<?php

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
 * Define plugin constants
 */
define( 'PLUGIN_MAIN_FILE', __FILE__ );
define( 'WP_ADMIN_VUE_VERSION', '1.0.0' );
define( 'TEXTDOMAIN', 'wp-admin-vue');
define( 'PAGE_SLUG', 'wp-admin-vue');

function activation() {
	require plugin_dir_path( __FILE__ ) . 'includes/Activator.php';
	wpAdminVue\Includes\Activator::activate();
}
function deactivation() {
	require plugin_dir_path( __FILE__ ) . 'includes/Deactivator.php';
	wpAdminVue\Includes\Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activation' );
register_deactivation_hook( __FILE__, 'deactivation' );

add_action( 'init', function(){
	if ( ! defined( 'WP_Admin_Vue_Plugin_Loaded' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/Controller.php';
		new wpAdminVue\Includes\Controller();
    }
});