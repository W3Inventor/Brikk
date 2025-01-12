<?php

namespace Brikk\Includes\Src\Admin;

class Importer {

    use \Brikk\Includes\Src\Traits\Singleton;

    function __construct() {

        $this->init_actions();

    }

    protected function init_actions() {

        add_filter( 'routiz/importer/demos', [ $this, 'add_demos' ] );

    }

    public function add_demos( $demos ) {

        $demos += [
            'booking' => [
                'name' => esc_html__('Booking', 'brikk'),
                'path' => BK_PATH . 'includes/demos/booking/',
                'thumbnail' => BK_URI . 'includes/demos/booking/thumbnail.png',
            ],
            'apartments' => [
                'name' => esc_html__('Apartments', 'brikk'),
                'path' => BK_PATH . 'includes/demos/apartments/',
                'thumbnail' => BK_URI . 'includes/demos/apartments/thumbnail.png',
            ],
        ];

        return $demos;

    }

}
