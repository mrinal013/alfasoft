<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mrinal013/alfasoft
 * @since             1.0.0
 * @package           Contact_Management
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Management
 * Plugin URI:        https://github.com/mrinal013/alfasoft
 * Description:       Contact Management Plugin
 * Version:           1.0.0
 * Author:            Mrinal Haque
 * Author URI:        mrinalbd.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define plugin constants
 */
define( 'PLUGIN_ROOT_FILE', __FILE__  );
define( 'PLUGIN_ROOT_URL', plugin_dir_url(PLUGIN_ROOT_FILE ) );
define( 'Contact_Manager_VERSION', '1.0.0' );

function activation() {
	require plugin_dir_path( __FILE__ ) . 'includes/Activator.php';
	Contact_Management\Includes\Activator::activate();
}
function deactivation() {
	require plugin_dir_path( __FILE__ ) . 'includes/Deactivator.php';
	Contact_Management\Includes\Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activation' );
register_deactivation_hook( __FILE__, 'deactivation' );

add_action( 'init', function(){
	if ( ! defined( 'Contact_Management_Loaded' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/Controller.php';
		new Contact_Management\Includes\Controller();
    }
});
