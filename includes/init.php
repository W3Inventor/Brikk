<?php

namespace Brikk\Includes;

class Init {

    use \Brikk\Includes\Src\Traits\Singleton;

    function __construct() {

        Src\Admin::instance();
        Src\Assets::instance();
        Src\Menu::instance();
        Src\Setup::instance();
        Src\Widgets::instance();
        Src\Routiz::instance();
        Src\WooCommerce::instance();

    }

}
