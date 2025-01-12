<?php

global $wp_query;

if( ! function_exists('routiz') ) {
    return;
}

?>

<div class="brk-account-footer">
    <div class="brk-row">
        <div class="brk-grid brk-justify-space">
            <div class="brk-col-auto brk-col-md-12">
                <?php echo wp_kses( html_entity_decode( get_option( 'rz_footer_copy' ) ), Rz()->allowed_html() ); ?>
            </div>
            <?php $footer_account = get_option( 'rz_footer_account' ); ?>
            <?php if( $footer_account ): ?>
                <div class="brk-col-auto brk-col-md-12">
                    <?php echo wp_kses( html_entity_decode( $footer_account ), Rz()->allowed_html() ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
