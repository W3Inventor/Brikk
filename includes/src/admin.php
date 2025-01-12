<?php

namespace Brikk\Includes\Src;

use Form\Fields;

class Admin {

    use Traits\Singleton;

    function __construct() {

        if( is_admin() ) {

            Admin\Theme_Settings::instance();
            Admin\Required::instance();
            Admin\Importer::instance();
            Admin\Http\Xhr::instance();

            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        }

    }

    function enqueue_scripts() {

        // font awesome
        wp_enqueue_style( 'font-awesome-5', BK_URI . 'assets/css/font-awesome.css' );

        // rtl
        if( is_rtl() ) {
            wp_enqueue_style( 'brk-rtl', BK_URI . 'assets/dist/css/rtl.css', [ 'brk-admin-style' ], BK_VERSION );
        }

        // admin main
        wp_enqueue_style( 'brk-admin-style', BK_URI . 'assets/dist/css/admin/admin.css' );
        wp_register_script( 'brk-admin-main', BK_URI . 'assets/dist/js/admin/admin.js', array('jquery'), BK_VERSION, true );
        $vars = array(
            'admin_ajax'        => admin_url('admin-ajax.php'),
            'nonce'             => wp_create_nonce('ajax-nonce'),
            'site_url'          => site_url('/'),
            'uri_assets'        => BK_URI,
            'strings'           => []
        );
        wp_localize_script( 'brk-admin-main', 'brikk_vars', $vars );
        wp_enqueue_script( 'brk-admin-main' );

    }

}
