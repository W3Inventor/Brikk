<?php

defined('ABSPATH') || exit;

global $rz_listing;

if( $cover_type = $rz_listing->type->get('rz_single_cover_type') ) {
    Brk()->the_template( sprintf( 'routiz/single/cover/%s', $cover_type ) );
}
