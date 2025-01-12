<?php

namespace Brikk\Includes\Src\Admin\Http;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Xhr {

	use \Brikk\Includes\Src\Traits\Singleton;

	public $actions;

    public function __construct() {

		if( wp_doing_ajax() ) {

            if( isset( $_REQUEST['action'] ) ) {

				new Endpoints\Endpoint_Example( $this );

            }
        }
	}
}
