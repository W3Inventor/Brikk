<?php

$current_endpoint = WC()->query->get_current_endpoint();

?>

<div class="brk-account-mobile-nav">
    <div class="brk-archive-dropdown">
    	<select name="mobile_nav" data-action="account-mobile-nav">
            <?php foreach( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                <option value="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"<?php if( is_wc_endpoint_url( $endpoint ) ) { echo ' selected="selected"'; } ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>