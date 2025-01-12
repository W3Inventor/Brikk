<?php

defined('ABSPATH') || exit;

global $rz_listing;

$rz_listing = new \Routiz\Inc\Src\Listing\Listing();
$cover_type = $rz_listing->type->get('rz_display_listing_cover');

?>

<div class="rz-listing<?php $rz_listing->the_classes(); ?>" <?php $rz_listing->the_attrs(); ?>>

    <?php if( $cover_type == 'image' or $cover_type == 'slider' ): ?>
        <div class="rz-listing-cover">
            <div class="rz-listing-cover-inner">

                <?php Rz()->the_template('routiz/explore/listing/gallery'); ?>
                <?php Rz()->the_template('routiz/explore/listing/priority'); ?>
                <?php Rz()->the_template('routiz/explore/listing/badges'); ?>

            </div>
        </div>
    <?php elseif( $cover_type == 'author' ): ?>

        <?php Rz()->the_template('routiz/explore/listing/author'); ?>

    <?php endif; ?>

    <?php if( ! $rz_listing->type->get('rz_display_hide_listing_details') ): ?>
        <a class="rz-listing-content" href="<?php echo esc_url( Brk()->get_listing_url_preserve_dates() ); ?>"<?php if( $rz_listing->type->get('rz_open_listing_new_tab') ) { echo ' target="_blank"'; } ?>>

            <?php Rz()->the_template('routiz/explore/listing/heading'); ?>
            <?php if( $cover_type == 'author' ): ?>
                <?php Rz()->the_template('routiz/explore/listing/priority'); ?>
            <?php endif; ?>
            <?php Rz()->the_template('routiz/single/open-hours'); ?>
            <?php Rz()->the_template('routiz/explore/listing/details-content'); ?>
            <?php Rz()->the_template('routiz/explore/listing/details-bottom'); ?>

        </a>
    <?php endif; ?>

</div>
