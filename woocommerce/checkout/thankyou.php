<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
				<?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'brikk' ); ?>
			</p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'brikk' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'brikk' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="brk-thank-you">
				<div class="">
					<i class="fas fa-check-circle"></i>
				</div>
				<div class="">
					<h2 class="wc-thank-title">Thank you !</h2>
					<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
						<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been received.', 'brikk' ), $order ); ?>
					</p>
				</div>
			</div>

			<table class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
               <tr>
				<td class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'brikk' ); ?>
					<strong><?php echo esc_html( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</td>

				<td class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'brikk' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</td>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<td class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'brikk' ); ?>
						<strong><?php echo esc_html( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</td>
				<?php endif; ?>

				<td class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'brikk' ); ?>
					<strong><?php echo do_shortcode( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</td>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<td class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'brikk' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</td>
				<?php endif; ?>
				</tr>
			</table>

		<?php endif; ?>
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>
		<h2 class="wc-thank-title">Thank you !</h2>
		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been received.', 'brikk' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>