<?php

if( ! function_exists('brikk') ) {
    function brikk() {
        return \Brikk\Includes\Utils\Register::instance();
    }
}

if( ! function_exists('Brk') ) {
    function Brk() {
    	return brikk()->helpers();
    }
    brikk()->register( 'helpers', \Brikk\Includes\Utils\Helpers::instance() );
    brikk()->register( 'breadcrumbs', \Brikk\Includes\Utils\Breadcrumbs\Breadcrumbs::instance() );
}
