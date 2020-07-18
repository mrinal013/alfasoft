<?php

namespace wpAdminVue\Includes;

use wpAdminVue\Includes\Loader as Loader;
use wpAdminVue\Includes\I18n as I18n;
use wpAdminVue\Admin\Admin as Admin;
use wpAdminVue\Frontend\Frontend as Frontend;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       mrinalbd.com
 * @since      1.0.0
 *
 * @package    Wp_Admin_Vue
 * @subpackage Wp_Admin_Vue/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Admin_Vue
 * @subpackage Wp_Admin_Vue/includes
 * @author     Mrinal Haque <mrinalhaque99@gmail.com>
 */
class Controller {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Admin_Vue_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->wp_admin_vue_operation();
		if ( defined( 'WP_ADMIN_VUE_VERSION' ) ) {
			$this->version = WP_ADMIN_VUE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-admin-vue';
	}

	public function wp_admin_vue_operation() {
		if ( defined( 'WP_Admin_Vue_Plugin_Loaded' ) ) { 
			return; 
		}
		define( 'WP_Admin_Vue_Plugin_Loaded', true );
		if( $this->dependency_check() ) {
			add_action( 'admin_notices', [ $this, 'sample_admin_notice__success' ] );
			$this->autoload();
			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
			$this->run();
		}
	}

	/**
	 * Admin notice on activation
	 */
	function sample_admin_notice__success() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e( 'Notice on activation!', 'sample-text-domain' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Autoload all files depend on demand
	 * 
	 * @since 1.0.0
	 */
	public function autoload() {
		require_once dirname( __DIR__ ) . "/vendor/autoload.php";
	}

	/**
	 * This method do the checking task at the time of plugin initialization.
	 * 
	 * @since 1.0.0
	 */
	public function dependency_check() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins' );

		$dependency_plugins = [ 
			'woocommerce/woocommerce.php' => '3.0',
		];

		$dependency_plugin_not_installed_error = [];
		$dependency_plugin_inactive_error = [];
		$dependency_plugin_version_error = [];

		if( ! empty( $dependency_plugins ) && ! empty( $active_plugins ) && ! empty( $installed_plugins) ) {
			foreach( $dependency_plugins as $dependency_plugin_main_file => $dependency_plugin_version ) {
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

		$dependency_error = 
			! empty( $dependency_plugin_not_installed_error ) || 
			! empty( $dependency_plugin_inactive_error ) || 
			! empty( $dependency_plugin_version_error ) 
		? true : false;

		if( $dependency_error ) {
			deactivate_plugins( plugin_basename( PLUGIN_MAIN_FILE ) );
			add_action( 'admin_head', [ $this, 'hide_plugin_activation_notice' ] );
			add_action( 'admin_notices', [ $this, 'dependency_error_notice' ] );
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Admin_Vue_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

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

		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_admin_menu' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_admin_submenu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Wp_Admin_Vue_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Hide auto deactivation notice.
	 * When dependent plugin is not active, this plugin automatically deactivated.
	 * This method hide this notification.
	 * 
	 * @since 1.0.0
	 */
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
			<p><?php _e( 'Done!', TEXTDOMAIN ); ?></p>
		</div>
		<?php
	}

}
