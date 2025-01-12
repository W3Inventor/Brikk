<?php

$mobile_bar_nav = [];

?>

<div class="brk-mobile-bar brk--names-<?php echo (int) get_option('rz_mobile_bar_display_names') ? 'yes' : 'no'; ?>">
    <div class="brk-mobile-row">
        <ul>

            <?php if( function_exists( 'routiz' ) && routiz()->notify ): ?>
                <?php $active_site = routiz()->notify->get_active_site(); ?>
                <?php $mobile_bar_nav = Rz()->json_decode( get_option('rz_mobile_bar_nav') ); ?>
                <?php if( is_array( $mobile_bar_nav ) ): ?>
                    <?php $is_user_logged_in = is_user_logged_in(); ?>
                    <?php foreach( $mobile_bar_nav as $item ): ?>

                        <?php

                            if(
                                ( $is_user_logged_in and $item->fields->hide_in ) or
                                ( ! $is_user_logged_in and $item->fields->hide_out )
                            ) {
                                continue;
                            }

                            $item_url = '#';
                            $item_attr = [];
                            $has_notification = false;

                            if( $item->template->id == 'defined' ) {
                                switch( $item->fields->id ) {
                                    case 'explore':
                                        $item_url = Rz()->get_explore_page_url();
                                        break;
                                    case 'submission':
                                        $item_url = get_permalink( get_option('rz_page_submission') );
                                        break;
                                    case 'messages':
                                        if( $is_user_logged_in ) {
                                            if( function_exists('wc_get_account_endpoint_url') ) {
                                                $item_url = wc_get_account_endpoint_url('messages');
                                            }
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                    case 'notifications':
                                        if( $is_user_logged_in ) {
                                            $item_attr[] = 'data-action="toggle-side"';
                                            $has_notification = true;
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                    case 'favorites':
                                        $item_attr[] = $is_user_logged_in ? 'data-modal="favorites"' : 'data-modal="signin"';
                                        break;
                                        
                                    case 'signup':
                                        if( $is_user_logged_in ) {
                                            $item_url = wp_logout_url( home_url() );
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                        
                                        case 'logout':
                                        if( $is_user_logged_in ) {
                                            $item_url = wp_logout_url( home_url() );
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                        
                                }
                            }else{
                                $item_url = $item->fields->url;
                            }

                        ?>

                        <li class="<?php if( $item->fields->highlight ) { echo 'brk--focus'; } ?>">
                            <a href="<?php echo esc_url( $item_url ); ?>" data-name="<?php echo esc_attr( $item->fields->name ); ?>" <?php echo implode( ' ', $item_attr ); ?>>
                                <i class="<?php echo esc_attr( $item->fields->icon ); ?>"></i>
                                <?php if( $has_notification && $active_site ): ?>
                                    <em class="brk--notif"><?php echo (int) $active_site; ?></em>
                                <?php endif; ?>
                                <span><?php echo esc_html( $item->fields->name ); ?></span>
                            </a>
                        </li>

                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if( ! is_array( $mobile_bar_nav ) or empty( $mobile_bar_nav ) ): ?>
                <li></li>
            <?php endif; ?>

            <li>
                <a href="#" data-action="toggle-mobile-nav">
                    <i class="material-icon-menu"></i>
                    <span><?php echo esc_html_e('Menu', 'brikk'); ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>

<?php get_template_part('templates/mobile/navigation'); ?>
