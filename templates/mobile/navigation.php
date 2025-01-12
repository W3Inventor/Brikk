<?php

use \Routiz\Inc\Src\User;

?>

<div class="brk-mobile-nav">
    <div class="brk--header">
        <div class="brk-site-logo">
            <a href="<?php echo get_home_url(); ?>">
                <?php if( $logo = Brk()->get_logo() ): ?>
                    <img src="<?php echo esc_url( $logo ); ?>">
                <?php else: ?>
                    <span class="brk-site-title brk-font-heading">
                        <?php echo esc_html( Brk()->get_name() ); ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <div class="brk--nav">
        <?php if( has_nav_menu('mobile') ): ?>
            <nav class="brk-nav-mobile">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'mobile',
                        'container' => false
                    ]);
                ?>
            </nav>
        <?php else: ?>
            <p class="brk-no-nav"><strong><?php esc_html_e( 'Select menu by going to Admin > Appearance > Menus', 'brikk' ); ?></strong></p>
        <?php endif; ?>
    </div>
    <div class="brk--footer">
        <?php if( function_exists('routiz') and is_user_logged_in() ): ?>
            <?php $user = new User( get_current_user_id() ); ?>
            <?php $userdata = get_userdata( $user->id ); ?>
            <div class="brk--avatar">
                <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                    <?php $user->avatar(); ?>
                </a>
            </div>
            <div class="brk--meta">
                <span>
                    <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                        <?php echo esc_html( $userdata->display_name ); ?>
                    </a>
                </span>
                <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                    <?php esc_html_e( 'Show profile', 'brikk' ); ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="brk-ml-auto">
            <a href="#" class="brk--close" data-action="toggle-mobile-nav">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</div>