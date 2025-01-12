<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$dashboard_icons = apply_filters('routiz/account/navigation/icons', [
	'dashboard' => 'material-icon-home',
	'listings' => 'material-icon-location_onplaceroom',
	'messages' => 'material-icon-chat',
	'entries' => 'material-icon-add_circle',
	'payouts' => 'material-icon-account_balance_wallet',
	'notification-settings' => 'material-icon-notifications_active',
	'orders' => 'material-icon-library_add_check',
	'downloads' => 'material-icon-file_downloadget_app',
	'edit-address' => 'material-icon-businessdomain',
	'edit-account' => 'material-icon-style',
	'customer-logout' => 'material-icon-httpslock',
]);

?>

<div class="brk-account-bar">
	<nav class="brk-account-nav">
		<ul>
			<?php foreach( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
						<?php
							echo array_key_exists( $endpoint, $dashboard_icons ) ? sprintf( '<i class="%s"></i>', esc_html( $dashboard_icons[ $endpoint ] ) ) : '<i class="material-icon-fiber_manual_record"></i>';
						?>
						<span><?php echo esc_html( $label ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
