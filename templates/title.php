<?php

if( Brk()->get_meta('rz_hide_heading') ) {
    return;
}

// $title = get_the_title();
$title = single_post_title( '', false );

if( is_category() or is_tag() or is_date() ) {
    $title = get_the_archive_title();
}

if( is_404() ) {
    $title = 404;
}

if( is_home() ) {
    $blog_page_id = get_option('page_for_posts'); 
        $blog_page_title = get_the_title($blog_page_id);
        $title = esc_html__( $blog_page_title, 'brikk' );
}

if( is_search() ) {
    $title = sprintf( esc_html__( 'Searching for `%s`', 'brikk' ), get_search_query() );
}

if( is_author() ) {
    $author = get_queried_object();
    $title = $author->display_name;
}

if( class_exists( 'WooCommerce' ) and is_shop() ) {
    $title = esc_html__( 'Shop', 'brikk' );
}

?>

<?php if( ! Brk()->get_meta( 'disable_page_title' ) ): ?>
    <header class="brk-page-title">
        <div class="brk-row">
            <?php if( is_single() and get_post_type() == 'post' ): ?>
                <div class="brk-categories">
                    <?php $categories = get_the_category(); ?>
                    <?php if( $categories ): ?>
                        <ul>
                            <?php foreach( $categories as $category ): ?>
                                <li>
                                    <a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>">
                                        <?php echo esc_html( $category->name ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if( $title ): ?>
                <h1 class="brk--title">
                    <?php echo do_shortcode( $title ); ?>
                </h1>
            <?php endif; ?>

            <?php if( ! ( is_single() and get_post_type() == 'post' ) ): ?>
                <?php get_template_part('templates/breadcrumb'); ?>
            <?php else: ?>
                <div class="brk-post-date">
                    <i class="far fa-calendar-alt"></i>
                    <span><?php echo esc_html( get_the_date() ); ?></span>
                </div>
            <?php endif; ?>
            <?php if( is_archive() && $term_description = term_description() ): ?>
                <div class="rz-row brk-boxed">
                    <p><?php echo do_shortcode( wp_kses_post( $term_description ) ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </header>
<?php endif; ?>
