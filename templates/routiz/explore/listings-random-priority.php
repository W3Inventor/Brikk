<?php

defined('ABSPATH') || exit;

global $rz_explore;

$cols = 5;

if( $rz_explore->get_display_type() == 'map' ) {
    $cols = 2;
}

$listings_num = max( 1, (int) get_option('rz_random_promoted_listings_num') );

$args = $rz_explore->query()->query;
$args['posts_per_page'] = $listings_num;
$args['orderby'] = 'rand';
$args['offset'] = 0;
$args['meta_query']['filters'][] = [
    'key' => 'rz_priority',
    'value' => 1,
    'compare' => '>='
];

$query = new \WP_Query( $args );

?>

<?php if ( $query->have_posts() ): ?>
    <h4 class="brk-priority-title"><?php esc_html_e('Promoted', 'brikk'); ?></h4>
    <ul class="rz-listings" data-cols="<?php echo (int) $cols; ?>">
        <?php while( $query->have_posts() ): $query->the_post(); ?>
            <li class="rz-listing-item <?php Rz()->listing_class(); ?>">
                <?php Rz()->the_template('routiz/explore/listing/listing'); ?>
            </li>
        <?php endwhile; wp_reset_postdata(); ?>
    </ul>
    <span class="brk-priority-separator"></span>
<?php endif; ?>
