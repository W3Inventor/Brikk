<?php

namespace Brikk\Includes\Src;

class Menu {

    use Traits\Singleton;

    function __construct() {

        add_filter( 'nav_menu_link_attributes', [ $this, 'format_menu_link' ], 10, 4 );

    }

    public function format_menu_link( $atts, $item, $args, $depth ) {

        if( function_exists('routiz') ) {
            $atts['href'] = Rz()->format_menu_link( $atts['href'] );
        }

        return $atts;

    }

}
