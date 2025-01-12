<?php

defined('ABSPATH') || exit;

global $rz_listing;
$rz_listing = new \Routiz\Inc\Src\Listing\Listing();

?>

<li data-id="<?php echo (int) $rz_listing->id; ?>">
    <div class="rz-infobox">

        <div class="rz-infobox-cover">

            <?php Rz()->the_template('routiz/explore/listing/gallery'); ?>

            <?php Rz()->the_template('routiz/explore/listing/priority'); ?>

            <?php Rz()->the_template('routiz/explore/listing/badges'); ?>

        </div>

        <a class="rz-infobox-content" href="<?php echo esc_url( Brk()->get_listing_url_preserve_dates() ); ?>"<?php if( $rz_listing->type->get('rz_open_listing_new_tab') ) { echo ' target="_blank"'; } ?>>

            <?php Rz()->the_template('routiz/explore/listing/heading'); ?>

            <?php Rz()->the_template('routiz/explore/listing/details-bottom'); ?>

        </a>

    </div>
</li>
