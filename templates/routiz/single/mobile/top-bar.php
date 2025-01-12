<?php

defined('ABSPATH') || exit;

global $rz_listing;

?>

<div class="brk-mobile-listing-top">
    <div class="brk-row">
        <div class="brk-grid">
            <div class="brk-col-6">
                <a href="<?php echo esc_url( Rz()->get_explore_page_url([ 'type' => $rz_listing->type->get('rz_slug') ]) ); ?>" data-action="browser-back">
                    <i class="fas fa-chevron-left brk-mr-1"></i>
                    <span><?php esc_html_e('Back', 'brikk'); ?></span>
                </a>
            </div>
            <div class="brk-col-6">
                <!-- // -->
            </div>
        </div>
    </div>
</div>