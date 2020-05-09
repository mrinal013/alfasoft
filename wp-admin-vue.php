<?php

use includes\Wp_Admin_Vue;
use includes\Wp_Admin_Vue_Activator;
use includes\Wp_Admin_Vue_Deactivator;

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
define( 'WP_ADMIN_VUE_VERSION', '1.0.0' );
define( 'TEXTDOMAIN', 'wp-admin-vue');
define( 'PAGE_SLUG', 'wp-admin-vue');

/**
 * The main plugin class that is used to define necessary operation of run this plugin.
 */

class WP_Admin_Vue_Plugin_Boilerplate {
	public function __construct() {
		$this->wp_admin_vue_operation();	
	}

	public function wp_admin_vue_operation() {
		if( $this->wp_admin_vue_check() ) {
			register_activation_hook( __FILE__, [ $this, 'activate_wp_admin_vue' ] );
			register_deactivation_hook( __FILE__, [ $this, 'deactivate_wp_admin_vue' ] );
			$this->wp_admin_vue_autoload();
			( new Wp_Admin_Vue() )->run();
		}
	}

	/**
	 * Autoload all files depend on demand
	 */
	public function wp_admin_vue_autoload() {
		spl_autoload_register( function( $class ) {
			$file_name = plugin_dir_path( __FILE__ ) . str_replace( '\\', DIRECTORY_SEPARATOR, substr_replace( str_replace( '_', '-', strtolower( $class ) ), 'class-', strpos( $class, '\\', 0 ) + 1, 0 ) ) . '.php';

			if( file_exists( $file_name ) ) {
				require $file_name;
			}
		} );

		spl_autoload_register( function( $trait ) {
			$file_name = plugin_dir_path( __FILE__ ) . str_replace( '\\', DIRECTORY_SEPARATOR, substr_replace( str_replace( '_', '-', strtolower( $trait ) ), 'trait-', strpos( $trait, '\\', 0 ) + 1, 0 ) ) . '.php';

			if( file_exists( $file_name ) ) {
				require $file_name;
			}
		} );

	}

	/**
	 * The method runs during plugin activation.
	 * This action is documented in includes/class-wp-admin-vue-activator.php
	 */
	function activate_wp_admin_vue() {
		Wp_Admin_Vue_Activator::activate();
	}

	/**
	 * The method runs during plugin deactivation.
	 * This action is documented in includes/class-wp-admin-vue-deactivator.php
	 */
	function deactivate_wp_admin_vue() {
		Wp_Admin_Vue_Deactivator::deactivate();
	}
	/**
	 * This method do the checking task at the time of plugin initialization.
	 */
	public function wp_admin_vue_check() {
		 
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins' );

		$dependency_plugins = [ 
			// 'woocommerce/woocommerce.php' => '3.0',
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

		$dependency_error = 
			! empty( $dependency_plugin_not_installed_error ) || 
			! empty( $dependency_plugin_inactive_error ) || 
			! empty( $dependency_plugin_version_error ) 
		? true : false;

		if( $dependency_error ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_head', [ $this, 'hide_plugin_activation_notice' ] );
			add_action( 'admin_notices', [ $this, 'dependency_error_notice' ] );
			return false;
		} else {
			return true;
		}
	}

	public function hide_plugin_activation_notice() {
		?>
		<style>
		#message.updated {
			display: none;
		}
		</style>
		<?php
	}

	public function dependency_error_notice() {
		?>
		<div class="notice notice-error">
			<p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
		</div>
		<?php
	}

	
}

new WP_Admin_Vue_Plugin_Boilerplate();
