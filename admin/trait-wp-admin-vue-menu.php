<?php
namespace admin;

trait WP_Admin_Vue_Menu {

    public function wp_admin_menu() {
		add_menu_page(
			__( 'Report', TEXTDOMAIN ),
			__( 'WP Admin with Vue', TEXTDOMAIN ),
			'manage_options',
			PAGE_SLUG,
			[ $this, 'wp_admin_vue_cb'],
			'dashicons-admin-customizer',
			76
		);
	}

	public function wp_admin_vue_cb() {
		echo "<div id='app'>{{ message }}</div>";
	}    
}