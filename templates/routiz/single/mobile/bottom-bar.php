<?php
 
defined('ABSPATH') || exit;
 
global $rz_listing;
 
// Decode the action types
$action_types = Rz()->json_decode($rz_listing->type->get('rz_action_types'));
 
if (!$action_types) {
    return;
}
 
// Get the mobile button label
$action_mobile_button_label = $rz_listing->type->get('rz_action_mobile_button_label');
 
if (!$action_mobile_button_label) {
    $action_mobile_button_label = esc_html__('View', 'brikk');
}
 
?>
 
<div class="brk-mobile-listing-bottom">
<div class="rz-w-100">
<a href="#" class="rz-button rz-button-accent rz-block" data-action="toggle-mobile-action">
<span>
<?php
                // Get the listing type ID
                $listing_type_id = $rz_listing->get('rz_listing_type');
 
                // Initialize variables
                $final_price = 0;
                $service_fees = '';
                $service_fees_percentage = 0;
                $service_fees_fixed = 0;
 
                // Check if listing type ID is valid
                if (!empty($listing_type_id)) {
                    // Retrieve the listing type object
                    $listing_type_object = get_post($listing_type_id);
 
                    // Check if the listing type object is valid
                    if ($listing_type_object) {
                        // Retrieve the service fee type and amounts using the listing type ID
                        $service_fees = get_post_meta($listing_type_id, 'rz_service_fee_type', true);
                        $service_fees_percentage = floatval(get_post_meta($listing_type_id, 'rz_service_fee_amount_percentage', true));
                        $service_fees_fixed = floatval(get_post_meta($listing_type_id, 'rz_service_fee_amount_fixed', true));
 
                        // Get the base price
                        $base_price = floatval($rz_listing->get('rz_price'));
 
                        // Calculate the final price based on service fee type
                        if ($service_fees === 'percentage' && $service_fees_percentage > 0) {
                            $final_price = $base_price + ($base_price * ($service_fees_percentage / 100));
                        } elseif ($service_fees === 'fixed' && $service_fees_fixed > 0) {
                            $final_price = $base_price + $service_fees_fixed;
                        } else {
                            $final_price = $base_price; // Default to base price if no valid service fee type
                        }
 
                        // Format the final price
                        $formatted_final_price = Rz()->format_price($final_price);
 
                        // Display the final price in the mobile button label
                        echo str_replace('[price]', $formatted_final_price, wp_kses_post($action_mobile_button_label));
                    } else {
                        echo esc_html__('Invalid listing type ID', 'brikk');
                    }
                } else {
                    echo esc_html__('No listing type ID found', 'brikk');
                }
                ?>
</span>
</a>
</div>
</div>