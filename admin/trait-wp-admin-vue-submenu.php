<?php
namespace admin;

trait WP_Admin_Vue_Submenu {
    public function wp_admin_all_quotes_submenu() {
        add_submenu_page( 'wp-admin-vue', 'All Quotes', 'All Quotes',
        'manage_options', 'all-quotes' );
    }

}