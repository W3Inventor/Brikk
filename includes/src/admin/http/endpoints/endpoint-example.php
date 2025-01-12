<?php

namespace Brikk\Includes\Src\Admin\Http\Endpoints;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Example extends Endpoint {

	public $action = 'brikk_example';

    public function action() {

		wp_send_json([
			'success' => true,
			'example' => true
		]);

	}

}
