<?php

namespace Brikk\Includes\Utils\Breadcrumbs;

class Breadcrumbs {

    use \Brikk\Includes\Src\Traits\Singleton;

    public $post_type;

    function __construct() {
        $this->post_type = get_post_type();
    }

    public function get() {
        echo sprintf( '<ul>%s</ul>', $this->links() );
    }

    public function links() {

        global $post;

        ob_start();

        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__('Home', 'brikk') . '</a></li>';

        switch( true ) {
            case is_category():
                echo '<li>';
                echo get_the_archive_title();
                echo '</li>';
                break;
            case is_404():
                echo '<li><span>404</span></li>';
                break;
            case is_home():
                $blog_page_id = get_option('page_for_posts');
                $blog_page_title = get_the_title($blog_page_id);
                echo '<li><span>' . esc_html__( $blog_page_title, 'brikk' ) . '</span></li>';
                break;
            case is_search():
                echo '<li><span>' . sprintf( esc_html__( 'Searching for `%s`', 'brikk' ), get_search_query() ) . '</span></li>';
                break;
            case is_author():
                $author = get_queried_object();
                echo '<li><span>' . esc_html__( 'Author', 'brikk' ) . '</span></li>';
                echo '<li><span>' . $author->display_name . '</span></li>';
                break;
            case is_single():
                if( $post->post_type == 'post' ) {
                    echo '<li>';
                    $categories = wp_get_post_categories( get_the_ID() );
                    foreach( $categories as $k => $category ) {
                        $category_obj = get_category( $category );
                        echo '<a href="' . esc_url( get_category_link( $category_obj ) ) . '">' . esc_html( $category_obj->name ) . '</a>';
                        if( count( $categories ) > $k + 1 ) {
                            echo ',';
                        }
                    }
                    echo '</li>';
                }
                if( get_the_title() ) {
                    echo '<li><span>' . get_the_title() . '</span></li>';
                }
                break;
            case is_page():
                if( $post->post_parent ) {
                    echo '<li><a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a></li>';
                }
                if( get_the_title() ) {
                    echo '<li><span>' . get_the_title() . '</span></li>';
                }
                break;
            case is_tag():
                echo '<li><span>' . sprintf( esc_html__('Tag: %s', 'brikk'), single_tag_title( '', false ) ) . '</span></li>';
                break;
            case class_exists( 'WooCommerce' ) and is_shop():
                echo '<li><span>' . esc_html__( 'Shop', 'brikk' ) . '</span></li>';
                break;

        }

        return ob_get_clean();

    }

}
