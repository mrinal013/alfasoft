<?php
namespace MCQ\Admin;

use MCQ\Admin\CPT as CPT;
use MCQ\Admin\Metabox as Metabox;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       mrinalbd.com
 * @since      1.0.0
 *
 * @package    MCQ
 * @subpackage MCQ/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MCQ
 * @subpackage MCQ/admin
 * @author     Mrinal Haque <mrinalhaque99@gmail.com>
 */

class Admin {

	use CPT, Metabox;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	public $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	public $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->mcq_post_type_init();

		$this->mcq_metabox_init();
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
		 * defined in MCQ_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MCQ_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, PLUGIN_ROOT_URL . 'admin/assets/css/style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MCQ_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MCQ_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post_type;
		if( 'mcq' == $post_type ) {
			wp_enqueue_script($this->plugin_name, PLUGIN_ROOT_URL . 'admin/assets/js/script.js', array('jquery'), $this->version, true);
		}
	}

}
