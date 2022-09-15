<?php
namespace Contact_Management\Admin;

use Contact_Management\Admin\CPT as CPT;
use Contact_Management\Admin\Metabox as Metabox;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       mrinalbd.com
 * @since      1.0.0
 *
 * @package    Contact_Management
 * @subpackage Contact_Management/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Contact_Management
 * @subpackage Contact_Management/admin
 * @author     Mrinal Haque <mrinalhaque99@gmail.com>
 */

class Admin {

	use CPT, Metabox;

	/**
	 * The name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $plugin_name    The name of this plugin.
	 */
	public $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $version    The current version of this plugin.
	 */
	public $version;

	/**
	 * 1. Initialize the class
	 * 2. Set its properties.
	 * 3. Register person post type from CPT trait
	 * 4. Init metabox for person posts from Metabox trait
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->person_post_type_init();

		$this->person_metabox_init();
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, PLUGIN_ROOT_URL . 'admin/assets/css/style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript file for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post_type;
		if( 'person' == $post_type ) {
			wp_enqueue_script($this->plugin_name, PLUGIN_ROOT_URL . 'admin/assets/js/script.js', array('jquery'), $this->version, true);
		}
	}

}
