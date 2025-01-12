<?php

namespace Brikk\Includes\Src;

class Routiz {

    use Traits\Singleton;

    function __construct() {

        add_action( 'routiz/explore/filters/before', [ $this, 'explore_filters_before' ] );

    }

    public function explore_filters_before() {

        Brk()->the_template('explore/filters/before');

    }

}
