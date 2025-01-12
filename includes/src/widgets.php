<?php

namespace Brikk\Includes\Src;

class Widgets {

    use Traits\Singleton;

    function __construct() {

        add_filter( 'get_archives_link', [ $this, 'wrap_archives_count' ] );
        add_filter( 'wp_list_categories', [ $this, 'wrap_category_count' ] );

    }

    public function wrap_archives_count( $links ) {
        $links = str_replace( '</a>&nbsp;(', '<span class="brk--count">', $links );
        $links = str_replace( ')</li', '</span></a></li', $links );
        return $links;
    }

    public function wrap_category_count( $links ) {
        $links = str_replace( '</a> (', '<span class="brk--count">', $links );
        $links = str_replace( ')', '</span></a>', $links );
        return $links;
    }

}
