<?php

global $wp_query;

?>

<div class="brk-account-heading">
    <h1 class="brk--title">
        <?php

            switch( true ) {
                case isset( $wp_query->query_vars['listings'] ):
                    esc_html_e( 'Listings', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['messages'] ):
                    esc_html_e( 'Messages', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['entries'] ):
                    esc_html_e( 'Entries', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['payouts'] ):
                    esc_html_e( 'Payouts', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['orders'] ):
                    esc_html_e( 'Orders', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['downloads'] ):
                    esc_html_e( 'Downloads', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['edit-address'] ):
                    esc_html_e( 'Address', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['edit-account'] ):
                    esc_html_e( 'Account details', 'brikk' );
                    break;
                case isset( $wp_query->query_vars['notification-settings'] ):
                    esc_html_e( 'Notifications', 'brikk' );
                    break;
                default:
                    esc_html_e( 'Dashboard', 'brikk' );
            }

        ?>
    </h1>
</div>
