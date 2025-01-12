<?php

global $current_user;

$wide_header = false;
if( Brk()->is_wide_page() ) {
    $wide_header = true;
}
if( function_exists('routiz') and Rz()->is_explore() ) {
    $wide_header = true;
}
if( function_exists('is_account_page') and is_account_page() ) {
    $wide_header = true;
}

?>

<header class="brk-header">
    <?php if( ! $wide_header ): ?><div class="brk-row"><?php endif; ?>
        <div class="brk-site-header">
            <div class="brk-header-container">
                <div class="brk-site-logo">
                    <a href="<?php echo get_home_url(); ?>">
                        <?php if( $logo = Brk()->get_logo() ): ?>
                            <img src="<?php echo esc_url( $logo ); ?>">
                            <?php if( $logo_white = Brk()->get_logo_white() ): ?>
                                <div class="brk-logo-overlap">
                                    <img src="<?php echo esc_url( $logo_white ); ?>">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $tag = Brk()->get_title_tag(); ?>
                            <<?php echo esc_html( $tag ); ?> class="brk-site-title brk-font-heading">
                                <?php echo esc_html( Brk()->get_name() ); ?>
                            </<?php echo esc_html( $tag ); ?>>
                        <?php endif; ?>
                    </a>
                </div>
                <?php if( has_nav_menu('primary') ): ?>
                    <div class="brk-site-nav">
                        <nav class="brk-nav brk-nav-main">
                            <?php
                                wp_nav_menu([
                                    'theme_location' => 'primary',
                                    'container' => false
                                ]);
                            ?>
                        </nav>
                    </div>
                <?php else: ?>
                    <p class="brk-mb-0"><strong><?php esc_html_e( 'Select menu by going to Admin > Appearance > Menus', 'brikk' ); ?></strong></p>
                <?php endif; ?>
                <div class="brk-site-actions">
                    <nav class="brk-nav">
                        <ul>
                            <?php if( class_exists( 'woocommerce' ) and (int) WC()->cart->get_cart_contents_count() > 0 ): ?>
                                <?php global $woocommerce; ?>
                                <li>
                                    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="brk--pad">
                                        <i class="material-icon-shopping_basket">
                                            <span class="brk--dot">
                                                <?php echo (int) WC()->cart->get_cart_contents_count(); ?>
                                            </span>
                                        </i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if( is_user_logged_in() ):
                                 if(empty(get_option('rz_hide_notification_icon'))):
                                ?>
                                <li>
                                    <?php Brk()->the_template('globals/notifications'); ?>
                                </li>
                            <?php endif; endif; ?>
                            <li>
                                <?php if( ! is_user_logged_in() ): ?>
                                    <a href="#" class="brk--pad" data-modal="signin">
                                        <i class="material-icon-person"></i>
                                        <span><?php esc_html_e( 'Sign in', 'brikk' ); ?></span>
                                    </a>
                                <?php else: ?>
                                    <nav class="brk-nav brk-nav-user">
                                        <ul>
                                            <li class="menu-item-has-children">
                                                <?php if( function_exists('routiz') ): ?>
                                                    <a href="#" class="brk--pad">
                                                        <?php $user = new \Routiz\Inc\Src\User( get_current_user_id() ); ?>
                                                        <?php $user_avatar = $user->get_avatar(); ?>
                                                        <?php if(empty(get_option('rz_hide_user_icon'))):  ?>
                                                        <?php if( $user_avatar ): ?>
                                                            <img src="<?php echo esc_url( $user_avatar ); ?>" alt="<?php echo esc_attr( $current_user->display_name ); ?>">
                                                        <?php else: ?>
                                                            <i class="material-icon-person"></i>
                                                        <?php endif; endif; ?>
                                                        <span><?php echo esc_html( $current_user->display_name ); ?></span>
                                                    </a>
                                                <?php endif; ?>
                                                <ul class="sub-menu">
                                                    <?php if( class_exists( 'woocommerce' ) and get_option('woocommerce_myaccount_page_id') ): ?>
                                                        <li>
                                                            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                                                                <?php esc_html_e( 'Dashboard', 'brikk' ); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'messages' ) ); ?>">
                                                                <?php esc_html_e( 'Messages', 'brikk' ); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'entries' ) ); ?>">
                                                                <?php esc_html_e( 'Entries', 'brikk' ); ?>
                                                            </a>
                                                        </li>
                                                        <?php if( get_option('rz_enable_dropdown_favorites') ): ?>
                                                            <li>
                                                                <a href="#" data-modal="favorites">
                                                                    <?php esc_html_e( 'Favorites', 'brikk' ); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if( get_user_meta( get_current_user_id(), 'rz_role', true ) == 'business' ): ?>
                                                            <li class="rz--separator"></li>
                                                            <li>
                                                                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'listings' ) ); ?>">
                                                                    <?php esc_html_e( 'Listings', 'brikk' ); ?>
                                                                </a>
                                                            </li>
                                                            <?php if( get_option('rz_enable_payouts') ): ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'payouts' ) ); ?>">
                                                                        <?php esc_html_e( 'Payouts', 'brikk' ); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if( get_option('rz_enable_dropdown_favorites') ): ?>
                                                            <li>
                                                                <a href="#" data-modal="favorites">
                                                                    <?php esc_html_e( 'Favorites', 'brikk' ); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if( class_exists( 'woocommerce' ) and get_option('woocommerce_myaccount_page_id') ): ?>
                                                        <li class="rz--separator"></li>
                                                        <li>
                                                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>">
                                                                <?php esc_html_e( 'Account details', 'brikk' ); ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">
                                                            <?php esc_html_e( 'Logout', 'brikk' ); ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                <?php endif; ?>
                            </li>
                             <?php

                            $listing_types = get_posts([
                                            'post_type' => 'rz_listing_type',
                                            'post_status' => 'publish',
                                            'posts_per_page' => -1,
                                            'meta_query' => [
                                                [
                                                    'key' => 'rz_disable_user_submission',
                                                    'value' => '',
                                                    'compare' => '='
                                                ],
                                            ]
                                        ]);

                // Check if there's only one listing type
                if (count($listing_types) === 1) {
                    $submission_id = get_option('rz_page_submission');
                    $submission_slug = get_post_field('post_name', $submission_id); 
                    
                    $single_listing_type = $listing_types[0];
                    $listing_slug = Rz()->get_meta('rz_slug', $single_listing_type->ID);

                    // Construct the redirect URL with submission slug and query string
                    $redirect_url = home_url('/' . $submission_slug . '/');
                    $redirect_url = add_query_arg('type', $listing_slug, $redirect_url); 
                }
                else
                {
                    $redirect_url = esc_url( get_permalink( get_option('rz_cta_target') ) );
                }




if ( get_option('rz_enable_cta') ) {
    $show_cta = false;
    $cta_label = get_option('rz_cta_label');
    
    if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $rz_role = get_user_meta($current_user->ID, 'rz_role', true);

        if ($rz_role === 'business') {
            $show_cta = true;
        }
    } else {
        $show_cta = true; // Show CTA for users who are not logged in
    }

    if ( $show_cta ) {
        ?>
        <li>
            <div class="brk-site-cta">
    <?php if ( ! is_user_logged_in() ) : ?>
        <a href="javascript:void(0);" class="rz-button rz-button-accent rz-small" data-modal="signin">
            <span><?php echo esc_html( $cta_label ); ?></span>
        </a>
    <?php else : ?>
        <a href="<?php echo $redirect_url; ?>" class="rz-button rz-button-accent rz-small">
            <span><?php echo esc_html( $cta_label ); ?></span>
        </a>
    <?php endif; ?>
</div>

        </li>
        <?php
    }
}
?>

                        </ul>
                    </nav>
                </div>
            </div>
        <?php if( ! $wide_header ): ?></div><?php endif; ?>
    </div>
</header>