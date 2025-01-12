<?php

namespace Brikk\Includes\Src\Admin;

use \Brikk\Includes\Src\Request\Request;
use \Routiz\Inc\Src\Admin\Panel;

class Theme_Settings {

    use \Brikk\Includes\Src\Traits\Singleton;

    function __construct() {

        if( function_exists('routiz') ) {

            // add settings page to rz_listing
            add_action( 'admin_menu' , [ $this, 'add_menu_page' ] );

            // update settings
            add_action( 'brikk/admin/update_theme_settings', [ $this, 'update_theme_settings' ] );

        }

    }

    public function enqueue_menu_scripts() {
        Panel::instance();
    }

    public function add_menu_page() {

        add_action( sprintf( 'load-%s',
            add_submenu_page(
                'edit.php?post_type=rz_listing_type', // parent slug
                esc_html__('Theme Settings', 'brikk'), // page title
                esc_html__('Theme Settings', 'brikk'), // menu title
                'manage_options', // capability
                'rz_theme_settings', // menu slug
                [ $this, 'settings_page_output' ]
            )),
            [ $this, 'enqueue_menu_scripts' ]
        );

    }

    public function settings_page_output() {

        if( isset( $_POST ) and ! empty( $_POST ) ) {
            do_action('brikk/admin/update_theme_settings');
        }

        Rz()->the_template('admin/theme-settings/theme-settings');

    }

    public function update_theme_settings() {

        if( isset( $_POST ) and ! empty( $_POST ) ) {

            foreach( $_POST as $id => $value ) {
                if( substr( $id, 0, 3 ) == 'rz_' ) {
                    update_option(
                        $id,
                        $value
                    );
                }
            }
        }
    }
}
