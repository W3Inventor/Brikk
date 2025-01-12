<?php

$has_footer = true;
if( function_exists('is_account_page') and is_account_page() ) {
    $has_footer = false;
}

if( function_exists('routiz') and Rz()->is_submission() ) {
    $has_footer = false;
}

if( function_exists('routiz') and Rz()->get_meta('rz_hide_footer') ) {
    $has_footer = false;
}

$page_wide = Brk()->is_wide_page();

$footer_columns = max( 3, min( 6, (int) get_option('rz_footer_columns') ) );

?>

<?php if( $has_footer ): ?>
    <div class="brk-footer">

        <?php if( is_active_sidebar('footer-top') ): ?>
            <div class="brk--top">
                <div class="brk-row">
                    <div class="brk--widgets">
                        <?php dynamic_sidebar('footer-top'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if( is_active_sidebar('footer') ): ?>
            <div class="brk--content" data-cols="<?php echo (int) $footer_columns; ?>">
                <div class="brk-row">
                    <div class="brk--widgets">
                        <?php dynamic_sidebar('footer'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php $footer_copy = get_option( 'rz_footer_copy' ); ?>
        <?php $footer_summary = get_option( 'rz_footer_summary' ); ?>
        <?php $footer_account_text = get_option( 'rz_footer_account' ); ?>
        <?php if( empty( $footer_copy ) ) { $footer_copy = esc_html( get_bloginfo('description') ); } ?>
        <?php if( ! empty( $footer_copy ) || ! empty( $footer_summary ) || ! empty( $footer_account_text ) ): ?>
            <div class="brk--bottom">
                <div class="brk-row">
                    <div class="brk--bottom-inner">
                        <div class="brk--cell-copy">
                            <p><?php echo do_shortcode( stripslashes( $footer_copy ) ); ?></p>
                        </div>
                        <?php if( ! empty( $footer_summary ) ): ?>
                            <div class="brk--cell-copy">
                                <p><?php echo do_shortcode( stripslashes( $footer_summary ) ); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if( ! empty( $footer_account_text ) ): ?>
                            <div class="brk--cell-copy">
                                <p><?php echo do_shortcode( stripslashes( $footer_account_text ) ); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if( has_nav_menu('bottom') ): ?>
                            <div class="brk-site-nav">
                                <nav class="brk-nav-bottom">
                                    <?php
                                        wp_nav_menu([
                                            'theme_location' => 'bottom',
                                            'container' => false,
                                            'depth' => 1
                                        ]);
                                    ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>

</div> <!-- end .site -->

<?php if( function_exists('routiz') ): ?>
    <?php get_template_part('templates/modals/lightbox'); ?>
<?php endif; ?>

<?php if( ! ( function_exists('routiz') and Rz()->is_submission() ) ): ?>
    <?php get_template_part('templates/mobile/bar'); ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>