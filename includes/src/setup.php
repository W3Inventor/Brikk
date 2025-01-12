<?php

namespace Brikk\Includes\Src;

class Setup {

    use Traits\Singleton;

    function __construct() {

        add_action( 'init', [ $this, 'support' ] );
        add_action( 'widgets_init', [ $this, 'widgets_init' ] );

        add_filter( 'excerpt_length', [ $this, 'excerpt_length' ], 999 );
        add_filter( 'excerpt_more', [ $this, 'excerpt_more' ], 999 );

        // render notification sidebar
        add_action( 'wp_footer', [ $this, 'notification_sidebar' ] );

    }

    public function support() {

        // Make theme available for translation.
        load_theme_textdomain( 'brikk', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);

        register_nav_menus([
			'primary' => esc_html__( 'Primary', 'brikk' ),
		]);

        register_nav_menus([
			'mobile' => esc_html__( 'Mobile', 'brikk' ),
		]);

        register_nav_menus([
			'bottom' => esc_html__( 'Footer Bottom', 'brikk' ),
		]);

        $GLOBALS['content_width'] = apply_filters( 'brk_content_width', 640 );

    }

    public function widgets_init() {

        register_sidebar([
            'name'          => 'Sidebar',
            'id'            => 'sidebar',
            'before_widget' => '<div class="brk-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h6 class="brk-widget-title">',
            'after_title'   => '</h6>',
        ]);

        register_sidebar([
            'name'          => 'Footer',
            'id'            => 'footer',
            'before_widget' => '<div class="brk-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h6 class="brk-widget-title">',
            'after_title'   => '</h6>',
        ]);

        register_sidebar([
            'name'          => 'Footer Top Area',
            'id'            => 'footer-top',
            'before_widget' => '<div class="brk-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h6 class="brk-widget-title">',
            'after_title'   => '</h6>',
        ]);

    }

    public function excerpt_length() {
        return 25;
    }

    public function excerpt_more() {
        return ' ...';
    }

    public function notification_sidebar() {

        if( is_user_logged_in() ) {
            Brk()->the_template('globals/notification-sidebar');
        }

    }

}
