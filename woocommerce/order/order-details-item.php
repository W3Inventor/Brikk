<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">

	<td class="woocommerce-table__product-name product-name">
		<?php
		$is_visible        = $product && $product->is_visible();
		$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

		echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ) );

		$qty          = $item->get_quantity();
		$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

		if ( $refunded_qty ) {
			$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
		} else {
			$qty_display = esc_html( $qty );
		}

		echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

		wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
			// Loop through order items
		    foreach( $order->get_items() as $item ) {
		        // Try to get "_event_ticket_info" item meta value (array)
		        $adults=$item->get_meta('_adults');
		        $childs= $item->get_meta('_children');
		       	$checkin=$item->get_meta('_checkin');
		        $checkout=$item->get_meta('_checkout');
		        $lis_id=$item->get_meta('_listing_id');
		        $data = json_decode($lis_id, true);
                $listing_id=    $data[0];
                // Assuming $listing_id contains the listing ID
				$listing_type_id = get_post_meta($listing_id, 'rz_listing_type', true); // Assuming Rz()->get_meta() retrieves the listing type ID

				if (!empty($listing_type_id)) {
				    $action_types_meta = get_post_meta($listing_type_id, 'rz_action_types', true);
                       
				    // Decode the JSON data to an array
				    $action_types_data = json_decode($action_types_meta, true);

				    // Initialize the variable to store the value of "id":"open_hours"
				    $open_hours_value = '';

				    // Loop through the data to find the "id":"open_hours" and extract its value
				    foreach ($action_types_data as $template) {
				        if (isset($template['template']['id']) && $template['template']['id'] === 'booking_appointments') {
				            $open_hours_value = $template['template']['id'];
				            break;
				        }
				    }
				}

		        if($adults!='') { ?>			
					<b style="display:block;">Adults x <?php echo esc_html($adults); ?></b>
				<?php  } 
					if($childs!=''){
				?>
					<b style="display:block;">Childs x <?php echo esc_html($childs); ?></b>
				<?php  } 

					if(!empty($checkin)){
				
		         if( $open_hours_value == 'booking_appointments') { ?>
					<b style="display:block;">Checkin :  <?php echo esc_html(Rz()->local_datetime_i18n( $checkin )); ?></b>
				<?php  } 
		         else {  ?>
					 <b style="display:block;">Checkin:  <?php echo esc_html(date_i18n( wc_date_format(), $checkin )); ?></b>
			      <?php	 }  
					 }  ?>
					<?php if(!empty($checkout)){ 
				
				     if( $open_hours_value == 'booking_appointments') { ?>
					<b style="display:block;">Checkout :  <?php echo esc_html(Rz()->local_datetime_i18n( $checkout )); ?></b>
				<?php  } 
		         else {  ?>
					 <b style="display:block;">Checkout :  <?php echo esc_html(date_i18n( wc_date_format(), $checkout )); ?></b>
			      <?php	 }  
			
				}
		}
		?>
	</td>

	<td class="woocommerce-table__product-total product-total">
		<?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</td>

</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>

</tr>

<?php endif; ?>