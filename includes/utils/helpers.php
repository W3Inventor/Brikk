<?php

namespace Brikk\Includes\Utils;

class Helpers {

    use \Brikk\Includes\Src\Traits\Singleton;

    function __construct() {}

    public function sanitize( $data ) {

        if( is_array( $data ) ) {
            foreach( $data as $k => $v ) {
                $data[ $k ] = is_array( $v ) ? $this->sanitize( $v ) : sanitize_text_field( $v );
            }
        }else{
            $data = sanitize_text_field( $data );
        }
        return $data;

    }

    public function get_option( $key, $default = '' ) {

        return get_option( $option_id, $default );

    }

    public function get_theme_option( $key, $default = '' ) {

        if( function_exists('get_field') ) {
            $option = get_field( $key, 'option' );
            return empty( $option ) ? $default : $option;
        }

    }

    public function get_meta( $key, $post_id = 0, $single = true ) {

        return get_post_meta( ( ( (int) $post_id > 0 ) ? $post_id : get_the_ID() ), $key, $single );

    }

    public function child_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_stylesheet_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function theme_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_template_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function the_template( $name ) {

        echo ! empty( $name ) ? $this->get_template( $name ) : '';

    }

    public function get_template_path( $name ) {

        // child theme
        if( is_child_theme() and $child_template_path = $this->child_template_path( $name ) ) {
            return $child_template_path;
        }
        // theme
        elseif( $theme_template_path = $this->theme_template_path( $name ) ) {
            return $theme_template_path;
        }

        return null;

    }

    public function get_template( $name ) {

        if( ! $template_path = $this->get_template_path( $name ) ) {
            return;
        }

        if( file_exists( $template_path ) ) {
            ob_start();
            include $template_path;
            return ob_get_clean();
        }

    }

    public function current_page() {

        if ( get_query_var('paged') ) {
	        return get_query_var('paged');
	    }elseif( get_query_var('page') ) {
	        return get_query_var('page');
	    }else{
	        return 1;
	    }

    }

    public function preloader() {
        return '<div class="brk-preloader brk-transition"><i></i><i></i></div>';
    }

    public function get_title_tag() {
        return is_front_page() ? 'h1' : 'p';
    }

    public function get_image( $attachment_id, $size = 'rz_listing' ) {

        $image_attrs = wp_get_attachment_image_src( $attachment_id, $size );

        if( isset( $image_attrs[0] ) ) {
            return $image_attrs[0];
        }

    }

    public function get_logo_image( $logo, $size = 'original' ) {

        $logo = str_replace( '\r\n', "<br>", $logo );
        $logo = json_decode( stripslashes( $logo ), false );

        if( isset( $logo[0] ) and isset( $logo[0]->id ) ) {
            return $this->get_image( $logo[0]->id, $size );
        }

        return;

    }

    public function pagination() {

        global $wp_query;

        $big = 999999999;

        echo paginate_links([
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $this->current_page() ),
            'total' => $wp_query->max_num_pages,
            'type' => 'list',
            'prev_text' => '<i class="fas fa-angle-left"></i>',
            'next_text' => '<i class="fas fa-angle-right"></i>',
        ]);

    }

    public function dummy( $icon = null, $height_ratio = null, $background_color = null, $color = null ) {

        if( empty( $icon ) ) {
            $icon = 'far fa-image';
        }

        $style = '';
        $style .= $height_ratio ? 'padding-top:' . $height_ratio . '%;' : '';
        $style .= $background_color ? 'background-color:' . $background_color . '!important;' : '';
        $style .= $color ? 'color:' . $color . ';' : '';
        return '<div class="brk-dummy-image" style="' . $style . '"><i class="' . $icon . '"></i></div>';

    }

    public function get_time_elapsed_string( $time ) {

        $etime = time() - $time;

        if ( $etime < 1 ) {
            return '0 seconds';
        }

        $a = [ 365 * 24 * 60 * 60       => esc_html__('year', 'brikk'),
                     30 * 24 * 60 * 60  => esc_html__('month', 'brikk'),
                          24 * 60 * 60  => esc_html__('day', 'brikk'),
                               60 * 60  => esc_html__('hour', 'brikk'),
                                    60  => esc_html__('minute', 'brikk'),
                                     1  => esc_html__('second', 'brikk')
        ];

        $a_plural = [
            'year'      => esc_html__('years', 'brikk'),
            'month'     => esc_html__('months', 'brikk'),
            'day'       => esc_html__('days', 'brikk'),
            'hour'      => esc_html__('hours', 'brikk'),
            'minute'    => esc_html__('minutes', 'brikk'),
            'second'    => esc_html__('seconds', 'brikk')
        ];

        foreach( $a as $secs => $str ) {
            $d = $etime / $secs;
            if( $d >= 1 ) {
                $r = round( $d );
                return sprintf( esc_html__('%s %s ago', 'brikk'), $r, $r > 1 ? $a_plural[ $str ] : $str );
            }
        }
    }

    public function get_post_first_category() {
        $category = get_the_category();
        return isset( $category[0] ) ? $category[0]->cat_name : '';
    }

    public function get_post_first_category_url() {
        $category = get_the_category();
        return isset( $category[0] ) ? get_category_link( $category[0] ) : '#';
    }

    public function user_has_gravatar( $email_address ) {

        return null;
    	// $headers = get_headers( 'http://www.gravatar.com/avatar/' . md5( strtolower( trim( $email_address ) ) ) . '?d=404' );
    	// return preg_match( '|200|', $headers[0] ) ? true : false;

    }

    public function get_font_family() {

        $font_families = [];

        $font_heading = get_option('rz_font_heading');
        $font_families[] = ( $font_heading ? esc_attr( $font_heading ) : 'Open Sans:wght@400;600;700;800' );

        $font_body = get_option('rz_font_body');
        $font_families[] = ( $font_body ? esc_attr( $font_body ) : 'Sen:wght@400;700;800' );

        return '&family=' . implode( '&family=', $font_families );

    }

    public function get_google_fonts() {
        return add_query_arg( 'display', 'swap', '//fonts.googleapis.com/css2' ) . $this->get_font_family();
    }

    public function get_name() {
        if( $site_name = get_option('rz_site_name') ) {
            return $site_name;
        }
        return get_bloginfo('name');
    }

    public function is_dark_header() {

        if( isset( $_GET['brk-no-dark'] ) ) {
            return;
        }

        $object_id = get_queried_object_id();

        return boolval( isset( $_GET['brk-dark'] ) or get_option('rz_enable_dark_header', $object_id) );

    }

    public function is_non_dark() {
        if( class_exists( 'WooCommerce' ) ) {
            return is_checkout() or is_account_page();
        }
    }

    public function is_wide_page() {

        if( isset( $_GET['brk-no-wide'] ) ) {
            return;
        }

        if( function_exists('is_account_page') and is_account_page() ) {
            return;
        }

        return boolval( Brk()->get_meta('rz_enable_wide_page') );

    }

    public function get_section_background( $props ) {

        extract( array_merge(
            \Brikk\Includes\Src\Components\Background::get_attributes(),
            (array) $props
        ));

        $image = Rz()->get_first_array_image( $bg_image, 'rz_gallery_large' );

        $style = '';
        if( $bg_color ) {
            $style .= 'background-color: ' . esc_attr( $bg_color ) . ';';
        }
        if( $image ) {
            $style .= 'background-image: url(' . esc_url( $image ) . ');';
        }

        $overlay = '';
        if( $bg_overlay_color ) {
            $overlay .= '<i style="background-color: ' . esc_attr( $bg_overlay_color ) . ';"></i>';
        }

        return '<span class="brk--bg" style="' . $style . '">' . $overlay . '</span>';

    }

    public function get_section_styles( $props ) {

        extract( array_merge(
            \Brikk\Includes\Src\Components\Background::get_attributes(),
            (array) $props
        ));

        $classes = [];
        $styles = '';

        if( $padding_top ) {
            $styles .= 'padding-top: ' . esc_attr( $padding_top ) . ';';
        }

        if( $padding_bottom ) {
            $styles .= 'padding-bottom: ' . esc_attr( $padding_bottom ) . ';';
        }

        if( $text_color ) {
            $styles .= 'color: ' . esc_attr( $text_color ) . ';';
        }

        if( $full_height ) {
            $classes[] = 'brk--full';
        }

        return (object)[
            'styles' => $styles,
            'classes' => implode( ' ', $classes )
        ];

    }

    public function get_logo() {

        $logo_type = get_option('rz_logo_type');
        return $logo_type == 'path' ? get_option('rz_logo_path') : Brk()->get_logo_image( get_option('rz_logo') );

    }

    public function get_logo_white() {

        $logo_type = get_option('rz_logo_type');
        $logo = $logo_type == 'path' ? get_option('rz_logo_path_white') : Brk()->get_logo_image( get_option('rz_logo_white') );
        return $logo ? $logo : $this->get_logo();

    }

    public function is_elementor( $post_id = 0 ) {

        if( ! class_exists('Elementor\Plugin') ) {
            return;
        }

        if( ! $post_id ) {
            $post_id = get_the_ID();
        }

        return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );

    }

    public function get_listing_url_preserve_dates() {

        $permalink = get_permalink();

        if( function_exists('routiz') ) {
            $request = \Routiz\Inc\Src\Request\Request::instance();

            if( ! $request->is_empty('booking_dates') ) {
                $date_params = $request->get('booking_dates');
                // start
                if( isset( $date_params[0] ) && ! empty( $date_params[0] ) ) {
                    $permalink = add_query_arg([
                        'date_start' => $date_params[0]
                    ], $permalink );
                }
                // end
                if( isset( $date_params[1] ) && ! empty( $date_params[1] ) ) {
                    $permalink = add_query_arg([
                        'date_end' => $date_params[1]
                    ], $permalink );
                }
            }

            // guests
            if( ! $request->is_empty('guests') ) {
                $permalink = add_query_arg([
                    'guests' => $request->get('guests')
                ], $permalink );
            }
            if( ! $request->is_empty('guest_adults') ) {
                $permalink = add_query_arg([
                    'guest_adults' => $request->get('guest_adults')
                ], $permalink );
            }
            if( ! $request->is_empty('guest_children') ) {
                $permalink = add_query_arg([
                    'guest_children' => $request->get('guest_children')
                ], $permalink );
            }
            if( ! $request->is_empty('guest_infants') ) {
                $permalink = add_query_arg([
                    'guest_infants' => $request->get('guest_infants')
                ], $permalink );
            }

        }

        return $permalink;

    }

    public function get_map_provider() {
        $map_provider = get_option('rz_map_provider');
        if( empty( $map_provider ) ) {
            $map_provider = 'google';
        }
        return $map_provider;
    }

}
