<?php

namespace Brikk\Includes\Src;

class Assets {

    use Traits\Singleton;

    function __construct() {

        add_action( 'after_setup_theme', [ $this, 'thumbnails' ] );
        add_action( 'body_class', [ $this, 'body_class' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'comment_form_before', [ $this, 'enqueue_comments_reply' ] );

        add_filter( 'routiz/chart/colors/main', function() {
            return get_option('rz_main_color') ? esc_attr( get_option('rz_main_color') ) : '#e61e4d';
        });

    }

    public function thumbnails() {

        add_image_size( 'brk_box', 543, 525, true );
        add_image_size( 'brk_box_main', 1086, 1050, true );
        add_image_size( 'brk_article', 708, 470, true );
        add_image_size( 'brk_trendy', 234, 234, true );
        add_image_size( 'brk_cover_large', 1118, 1006, true );
        add_image_size( 'brk_cover_small', 558, 502, true );

    }

    public function body_class( $classes ) {

        $classes[] = 'page';

        if( function_exists('routiz') and Brk()->get_meta('rz_overlap_header') ) {
            // if( is_front_page() ) {
                $classes[] = 'brk-overlap-header';

                if( Brk()->get_meta('rz_is_header_white_text_color') ) {
                    $classes[] = 'brk-header-text-white';
                }
            // }
        }

        $is_explore = ( function_exists('routiz') and Rz()->is_explore() ) ? Rz()->is_explore() : false;
        if( ! $is_explore ) {

            $is_account = ( function_exists('is_account_page') and is_account_page() );

            if( $is_account and is_user_logged_in() ) {
                $classes[] = 'brk-is-account-bar';
            }
        }

        // header
        if( $header_style = get_option('rz_header_style') ) {
            $classes[] = sprintf( 'brk-header--%s', esc_html( $header_style ) );
        }

        // dark mode header
        if( Brk()->is_dark_header() ) {
            $classes[] = 'brk-dark-header';
        }

        // wide page
        if( Brk()->is_wide_page() ) {
            $classes[] = 'brk-wide-page';
        }

        // hide heading
        if( Brk()->get_meta('rz_hide_heading') ) {
            $classes[] = 'brk-hide-heading';
        }

        // hide heading
        if( Brk()->get_meta('rz_invert_footer') ) {
            $classes[] = 'brk-invert-footer';
        }

        return $classes;

    }

    public function get_vars() {

        return [
            'admin_ajax'        => admin_url('admin-ajax.php'),
            'nonce'             => wp_create_nonce('ajax-nonce'),
            'site_url'          => site_url('/'),
            'uri_assets'        => BK_URI,
            'strings'           => [],
        ];
    }

    public function styles() {

        extract( array_merge(
            // defaults
            [
                'main' => '#e61e4d',
                'main_shade' => '#d80566',
                'minor' => '#000',
                'minor_shade' => '#555',
                'cursor_shade' => 'rgba(255,255,255,.35)',
                'marker' => '#fff',
                'marker_shade' => '#fff',
                'marker_text' => '#111',
                'marker_active' => '#111',
                'marker_active_shade' => '#444',
                'marker_active_text' => '#fff',
                'font_heading' => 'Sen',
                'font_body' => 'Open Sans',
            ],
            // values
            array_filter([
                'main' => get_option('rz_main_color'),
                'main_shade' => get_option('rz_main_shade_color'),
                'minor' => get_option('rz_minor_color'),
                'minor_shade' => get_option('rz_minor_shade_color'),
                'cursor_shade' => get_option('rz_cursor_shade_color'),
                'marker' => get_option('rz_marker_color'),
                'marker_shade' => get_option('rz_marker_shade_color'),
                'marker_text' => get_option('rz_marker_text_color'),
                'marker_active' => get_option('rz_marker_active_color'),
                'marker_active_shade' => get_option('rz_marker_active_shade_color'),
                'marker_active_text' => get_option('rz_marker_active_text_color'),
                'font_heading' => str_replace( '+', ' ', strstr( get_option('rz_font_heading'), ':', true ) ),
                'font_body' => str_replace( '+', ' ', strstr( get_option('rz_font_body'), ':', true ) ),
            ])
        ));

        ?>
            <style type="text/css">
                :root {
                    --main: <?php echo esc_attr( $main ); ?>;
                    --main-shade: <?php echo esc_attr( $main_shade ); ?>;
                    --minor: <?php echo esc_attr( $minor ); ?>;
                    --minor-shade: <?php echo esc_attr( $minor_shade ); ?>;
                    --cursor-shade: <?php echo esc_attr( $cursor_shade ); ?>;
                    --font-heading: <?php echo esc_attr( $font_heading ); ?>;
                    --font-body: <?php echo esc_attr( $font_body ); ?>;
                    --marker: <?php echo esc_attr( $marker ); ?>;
                    --marker-shade: <?php echo esc_attr( $marker_shade ); ?>;
                    --marker-text: <?php echo esc_attr( $marker_text ); ?>;
                    --marker-active: <?php echo esc_attr( $marker_active ); ?>;
                    --marker-active-shade: <?php echo esc_attr( $marker_active_shade ); ?>;
                    --marker-active-text: <?php echo esc_attr( $marker_active_text ); ?>;
                }
            </style>
        <?php

    }

    public function enqueue_scripts() {

        /*
         * main css
         *
         */
    	wp_enqueue_style( 'wp-style', get_stylesheet_uri(), [], BK_VERSION );
    	wp_enqueue_style( 'brk-style', BK_URI . 'assets/dist/css/main.css', [], BK_VERSION );
        wp_add_inline_style( 'brk-style', $this->styles() );

        if( Brk()->is_dark_header() ) {
            wp_enqueue_style( 'brk-dark', BK_URI . 'assets/dist/css/dark.css', [ 'brk-style', 'rz-style' ], BK_VERSION );
        }

        if( function_exists('routiz') and Rz()->is_submission() ) {
            wp_enqueue_style( 'brk-submission', BK_URI . 'assets/dist/css/submission.css', [], BK_VERSION );
        }

        /*
         * rtl
         *
         */
        if( is_rtl() ) {
            wp_enqueue_style( 'brk-rtl', BK_URI . 'assets/dist/css/rtl.css', [ 'brk-style' ], BK_VERSION );
        }

        /*
         * font icons
         *
         */
        wp_enqueue_style( 'font-awesome-5', BK_URI . 'assets/dist/fonts/font-awesome/css/all.min.css', [], BK_VERSION );
        wp_enqueue_style( 'material-icons', BK_URI . 'assets/dist/fonts/material-icons/style.css', [], BK_VERSION );

        /*
         * google fonts
         *
         */
        wp_enqueue_style( 'brk-fonts', Brk()->get_google_fonts(), [], null );

        /*
         * gsap
         *
         */
        wp_register_script( 'gsap', BK_URI . 'assets/dist/lib/gsap/gsap.min.js', [], BK_VERSION, true );

        /*
         * main js
         *
         */
        wp_register_script( 'brk-main', BK_URI . 'assets/dist/js/main.js', [ 'jquery', 'gsap' ], BK_VERSION, true );
        wp_localize_script( 'brk-main', 'brikk_vars', $this->get_vars() );
        wp_enqueue_script( 'brk-main' );

    }

    public function enqueue_comments_reply() {
        if( get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

}
