<?php

namespace Brikk\Includes\Src;

class WooCommerce {

    use Traits\Singleton;

    function __construct() {

        // support
        add_action( 'after_setup_theme', [ $this, 'support' ] );

        // set shop columns
        add_filter( 'loop_shop_columns', [ $this, 'loop_columns' ], 999 );

        // set default image sizes
        add_filter( 'woocommerce_get_image_size_thumbnail', [ $this, 'size_thumbnail' ] );

        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_archive_thumbnail' ] );

        add_filter( 'woocommerce_show_page_title', '__return_false' );

        remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

        // checkout strip cart
        add_filter( 'woocommerce_add_to_cart_redirect', [ $this, 'add_to_cart_redirect' ] );
        add_filter( 'template_redirect', [ $this, 'redirect_to_checkout_if_cart' ] );
        add_filter( 'woocommerce_product_single_add_to_cart_text', [ $this, 'cart_button_text' ] );
        add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'cart_button_text' ] );
        add_filter( 'wc_add_to_cart_message_html', [ $this, 'remove_add_to_cart_message' ] );

        // add additional fields to account page
        add_action( 'woocommerce_edit_account_form', [ $this, 'add_field_edit_account' ] );
        add_action( 'woocommerce_save_account_details', [ $this, 'save_account_details' ] );

        // add query vars
        add_filter( 'woocommerce_get_query_vars', [ $this, 'add_query_vars_filter' ] );

        // enable author's page for role `customer`
        remove_action( 'template_redirect', 'wc_disable_author_archives_for_customers', 10 );

        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

    }

    public function save_account_details( $user_id ) {

        if( ! function_exists('routiz') ) {
            return;
        }

        if( isset( $_POST['description'] ) ) {
            update_user_meta( $user_id, 'description', sanitize_text_field( $_POST['description'] ) );
        }

        if( isset( $_POST['user_avatar'] ) ) {
            update_user_meta( $user_id, 'user_avatar', sanitize_text_field( $_POST['user_avatar'] ) );
        }

        if( isset( $_POST['user_cover'] ) ) {
            update_user_meta( $user_id, 'user_cover', sanitize_text_field( $_POST['user_cover'] ) );
        }

    }

    public function add_field_edit_account() {

        if( ! function_exists('routiz') ) {
            return;
        }

        $form = new \Routiz\Inc\Src\Form\Component(
            \Routiz\Inc\Src\Form\Component::Storage_Field
        );

        $form->render([
            'type' => 'upload',
            'id' => 'user_avatar',
            'name' => esc_html__( 'Avatar image', 'brikk' ),
            'value' => get_user_meta( get_current_user_id(), 'user_avatar', true )
        ]);

        $form->render([
            'type' => 'upload',
            'id' => 'user_cover',
            'name' => esc_html__( 'Cover image', 'brikk' ),
            'value' => get_user_meta( get_current_user_id(), 'user_cover', true )
        ]);

        woocommerce_form_field(
            'description',
            [
                'type' => 'textarea',
                'required' => false,
                'label' => esc_html__( 'Biographical info', 'brikk' ),
            ],
            get_user_meta( get_current_user_id(), 'description', true )
        );

    }

    public function remove_add_to_cart_message( $message  ) {
        return '';
    }

    public function cart_button_text() {
        return esc_html__( 'Purchase', 'brikk' );
    }

    public function redirect_to_checkout_if_cart() {

        if( ! ( function_exists('is_cart') and is_cart() ) ) {
            return;
        }

    	global $woocommerce;

    	if ( $woocommerce->cart->is_empty() ) {
    		wp_redirect( get_home_url(), 302 );
    	}else{
    		wp_redirect( $woocommerce->cart->get_checkout_url(), 302 );
    	}

    	exit;

    }

    public function add_to_cart_redirect() {
        return wc_get_checkout_url();
    }

    // use woocommerce_checkout_fields to strip fields
    public function checkout_fields( $fields ) {

        unset( $fields['billing']['billing_company'] );
        unset( $fields['billing']['billing_address_1'] );
        unset( $fields['billing']['billing_address_2'] );
        unset( $fields['billing']['billing_state'] );
        unset( $fields['billing']['billing_city'] );
        unset( $fields['billing']['billing_phone'] );
        unset( $fields['billing']['billing_postcode'] );
        unset( $fields['billing']['billing_country'] );

        return $fields;

    }

    public function product_archive_thumbnail() {

        global $product;

        echo '<div class="brk-wc-image">';
        echo sprintf( '<div class="brk-wc-price">%s</div>', $product->get_price_html() );
        echo do_shortcode( $product->get_image('woocommerce_thumbnail') );
        echo '</div>';

    }

    public function support() {
        add_theme_support( 'woocommerce' );
        remove_theme_support( 'wc-product-gallery-zoom' );
        remove_theme_support( 'wc-product-gallery-lightbox' );
        remove_theme_support( 'wc-product-gallery-slider' );
    }

    public function size_thumbnail( $size ) {
        return [
            'width' => 600,
            'height' => 396,
            'crop' => true,
        ];
    }

    public function remove_my_account_links( $menu_links ) {

    	unset( $menu_links['downloads'] );
    	return $menu_links;

    }

    public function loop_columns() {
		return 3;
	}

    public function add_query_vars_filter( $vars ) {

        $vars['listings'] = 'listings';
        $vars['messages'] = 'messages';
        $vars['entries'] = 'entries';
        $vars['payouts'] = 'payouts';

        return $vars;

    }

}
