<?php
namespace wpAdminVue\Admin;

trait Submenu {

    public function wp_admin_submenu() {
        global $submenu;

        $capability = 'manage_options';

        $submenu[ PAGE_SLUG ][] = array( __( 'App', TEXTDOMAIN ), $capability, 'admin.php?page=' . PAGE_SLUG . '#/' );
        $submenu[ PAGE_SLUG ][] = array( __( 'Settings', TEXTDOMAIN ), $capability, 'admin.php?page=' . PAGE_SLUG . '#/settings' );
        $submenu[ PAGE_SLUG ][] = array( __( 'Inspire', TEXTDOMAIN ), $capability, 'admin.php?page=' . PAGE_SLUG . '#/inspire' );
    }

}