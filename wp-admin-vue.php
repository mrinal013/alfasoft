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
 * The main plugin class that is used to define necessary operation of run this plugin.
 */

class WP_Admin_Vue_Plugin_Boilerplate {
	public function __construct() {
		$this->wp_admin_vue_operation();	
	}

	public function wp_admin_vue_operation() {
		if( $this->wp_admin_vue_check() ) {
			$this->wp_admin_vue_autoload();
			( new Wp_Admin_Vue() )->run();
		}
	}

	public function wp_admin_vue_check() {
		 
		// Check if get_plugins() function exists.
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins' );

		$dependency_plugins = [ 
			'woocommerce/woocommerce.php' => '5.0',
		];

		$dependency_plugin_not_installed_error = [];
		$dependency_plugin_inactive_error = [];
		$dependency_plugin_version_error = [];

		if( ! empty( $dependency_plugins ) ) {
			foreach( $dependency_plugins as $dependency_plugin_main_file => $dependency_plugin_version ) {
				if( ! empty( $active_plugins ) && ! empty( $installed_plugins) ) {
					if( array_key_exists( $dependency_plugin_main_file, $installed_plugins ) ) {
						if( array_key_exists( $dependency_plugin_main_file, array_flip( $active_plugins ) ) ) {
							if( $installed_plugins[$dependency_plugin_main_file]['Version'] < $dependency_plugin_version ) {
								$dependency_plugin_version_error[ $installed_plugins[ $dependency_plugin_main_file ][ 'Name' ] ] = $dependency_plugin_version;
							}
						} else {
							$dependency_plugin_inactive_error[ $installed_plugins[ $dependency_plugin_main_file ][ 'Name' ] ] = $dependency_plugins[ $dependency_plugin_main_file ];
						}
					} else {						
						$dependency_plugin_not_installed_error[ $dependency_plugin_main_file ] = $dependency_plugin_version;
					}
				}
			}
		}
		// echo '<pre>';
		// echo 'Not installed' . '<br/>';
		// print_r($dependency_plugin_not_installed_error);
		// echo 'Installed but inactive'. '<br/>';
		// print_r($dependency_plugin_inactive_error);
		// echo 'Active but version problem' . '<br/>';
		// print_r($dependency_plugin_version_error);
		// echo '<pre>';
		// wp_die();	
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

new WP_Admin_Vue_Plugin_Boilerplate();
