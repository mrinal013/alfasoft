<?php
namespace wpAdminVue\Admin;

trait Menu {

    public function wp_admin_menu() {
		$menu = add_menu_page(
			__( 'Report', TEXTDOMAIN ),
			__( 'WP Admin with Vue', TEXTDOMAIN ),
			'manage_options',
			PAGE_SLUG,
			[ $this, 'wp_admin_vue_cb'],
			'dashicons-admin-customizer',
			76
		);
		add_action( 'load-' . $menu, [ $this, 'wp_admin_vue_pages_scripts' ] );
	}

	public function wp_admin_vue_pages_scripts() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	public function wp_admin_vue_cb() {
		?>
		<div id='app'></div>
		<?php
	}    
}