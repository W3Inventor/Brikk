<?php

defined('ABSPATH') || exit;

global $rz_listing;
$rz_listing = new \Routiz\Inc\Src\Listing\Listing();

?>

<section id="primary" class="content-area">
    <div class="site-main">

        <input type="hidden" id="rz_listing_id" value="<?php the_ID(); ?>">

        <?php Rz()->the_template('routiz/single/cover'); ?>

        <div class="brk-row">
            <div class="rz-grid">
                <div class="rz-col">

                    <div class="rz-single">
                        <div class="rz-container">
                            <div class="rz-content">
                                <?php Rz()->the_template('routiz/single/content'); ?>
                            </div>
                            <?php Rz()->the_template('routiz/single/sidebar'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<?php Rz()->the_template('routiz/single/modal/report'); ?>
<?php Rz()->the_template('routiz/single/modal/action-appointments'); ?>
<?php Rz()->the_template('routiz/single/mobile/top-bar'); ?>
<?php Rz()->the_template('routiz/single/mobile/bottom-bar'); ?>

<?php if( $rz_listing->type->get('rz_enable_nearby') ): ?>
    <div class="brk-nearby">
        <div class="brk-row">
            <?php Rz()->the_template('routiz/single/nearby'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if( $rz_listing->type->get('rz_enable_similar') ): ?>
    <div class="brk-similar">
        <div class="brk-row">
            <?php Rz()->the_template('routiz/single/similar'); ?>
        </div>
    </div>
<?php endif; ?>
