<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */ 

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table brk-table-checkout">
	<thead>
		<tr>
			<th class="product-image"><?php esc_html_e( 'Image', 'brikk' ); ?></th>
			<th class="product-name"><?php esc_html_e( 'Product', 'brikk' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'brikk' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-image">
						<div class="brk--image">
							<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="brk--remove">
								<i class="fas fa-times"></i>
							</a>
							<?php $product_type = $_product->get_type(); ?>
							<?php if( $product_type == 'listing_promotion' or $product_type == 'listing_plan' ): ?>
								<span class="brk--icon">
									<i class="fas fa-toolbox"></i>
								</span>
							<?php elseif( $product_type == 'listing_booking' ): ?>
								<span class="brk--icon">
									<i class="fas fa-calendar-alt"></i>
								</span>
							<?php elseif( $product_type == 'listing_claim' ): ?>
								<span class="brk--icon">
									<i class="fas fa-store"></i>
								</span>
							<?php elseif( $product_type == 'listing_subscription_plan' ): ?>
								<span class="brk--icon">
									<i class="fas fa-hourglass-start"></i>
								</span>
							<?php elseif( $product_type == 'listing_purchase' ): ?>
								<span class="brk--icon">
									<i class="fas fa-shopping-bag"></i>
								</span>
							<?php endif; ?>
							<?php if( $_product->get_image_id() ):
								if (isset($cart_item['listing_id'])) 
								{
								    $listing_id = $cart_item['listing_id'][0]; 
								    $featured_img = get_the_post_thumbnail($listing_id, 'thumbnail');
								}
								if(!empty($featured_img)) 
									   {
									   	echo  do_shortcode( get_the_post_thumbnail( $listing_id, 'thumbnail' ) );
									   }
									   else{
									   	echo do_shortcode( get_the_post_thumbnail( $_product->get_id(), 'thumbnail' ) );
									   }	
								?>
							<?php else: ?>	
								 <span class="brk--dummy"></span>

							<?php endif; ?>
							
						</div>
					</td>
					
					<td class="product-name">
						<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						
					</td>

					<td class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php 
					if (isset($cart_item['pricing'])) {
					    $adults = isset($cart_item['pricing']->guests) ? $cart_item['pricing']->guests : '';
					    $children = isset($cart_item['pricing']->children) ? $cart_item['pricing']->children : '';
					} 
						$checkin = !empty($cart_item['checkin']) ? $cart_item['checkin'] : '';
						$checkout = !empty($cart_item['checkout']) ? $cart_item['checkout'] : '';
				?>

				<?php
			
					// Assuming $listing_id is defined elsewhere in your code
					if (isset($listing_id)) {
					    $listing_type_id = get_post_meta($listing_id, 'rz_listing_type', true); // Assuming Rz()->get_meta() retrieves the listing type ID
					}
					if (!empty($listing_type_id)) {
				    $action_types_meta = get_post_meta($listing_type_id, 'rz_action_types', true);
	                 
				    // Decode the JSON data to an array
				    $action_types_data = json_decode($action_types_meta, true);

				    // Initialize the variable to store the value of "id":"open_hours"
				    $booking_action_type = '';

				    // Loop through the data to find the "id":"open_hours" and extract its value
				    foreach ($action_types_data as $template) {
				        if (isset($template['template']['id']) && $template['template']['id'] === 'booking_appointments') {
				            $booking_action_type = $template['template']['id'];
				            break;
				        }
				    }
				}

			?>

          <?php 
          		if($adults!=0) { ?>
				<tr>
				    <td></td>
				    <td class="product-name">Adults x <?php echo esc_html( $adults ); ?></td>
				    <td></td>
				</tr>
				<?php  } 
					if($children!=0){
				?>
				<tr>
					<td></td>
					<td class="product-name">Childs x <?php echo esc_html( $children); ?></td>
					<td>
						
					</td>
				</tr>
				<?php  } 

				if(!empty($checkin)){
									?>
				<?php if ($booking_action_type == 'booking_appointments') { ?>
					<tr>
					<td></td>
					<td class="product-name">Checkin :<td><b> <?php echo Rz()->local_datetime_i18n( $checkin ); ?></td>
					<td></td>
					</tr>
					<?php } else  { ?>
					<tr>
					<td></td>
					<td class="product-name">Checkin :  <?php echo date_i18n( wc_date_format(), $checkin ); ?></td>
					<td></td>
					</tr>
					<?php }  ?>
				<?php  } 

				if(!empty($checkout)){
				?>
				<?php if ($booking_action_type == 'booking_appointments') { ?>
				<tr>
					<td></td>
					<td class="product-name">Checkout : <strong><td><b><?php echo Rz()->local_datetime_i18n( $checkout ); ?></td></td></td>
					<td></td>
				</tr>
				<?php } else  { ?>
					<tr>
					<td></td>
					<td class="product-name">Checkout :  <?php echo date_i18n( wc_date_format(), $checkout ); ?></td>
					<td></td>
					</tr>
					<?php }  ?>
				<?php
				}
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<td class="rz--empty">&nbsp;</td>
			<th><?php esc_html_e( 'Subtotal', 'brikk' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<td class="rz--empty">&nbsp;</td>
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<td class="rz--empty">&nbsp;</td>
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<td class="rz--empty">&nbsp;</td>
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<td class="rz--empty">&nbsp;</td>
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<td class="rz--empty">&nbsp;</td>
			<th><?php esc_html_e( 'Total', 'brikk' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>