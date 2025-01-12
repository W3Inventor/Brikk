<?php

defined('ABSPATH') || exit;

global $rz_explore;

?>

<div class="brk-explore" id="rz-explore">
    <?php if( substr( $rz_explore->get_display_type(), 0, 3 ) == 'map' ): ?>
        <div class="brk-explore-content brk-no-select">
            <div class="brk--map">
                <div class="brk--inner">
                    <?php Rz()->the_template('routiz/explore/map/map'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="brk-explore-sidebar">
        <?php Rz()->the_template('routiz/explore/filters'); ?>
        <?php Rz()->the_template('routiz/explore/listings'); ?>
    </div>
</div>
