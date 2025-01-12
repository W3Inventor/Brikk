<div class="brk-mobile-header">
    <span class="brk--site-name brk-font-heading">
        <a href="<?php echo get_home_url(); ?>">
            <?php if( $logo = Brk()->get_logo() ): ?>
                <div class="brk--logo">
                    <img src="<?php echo esc_url( $logo ); ?>">
                </div>
                <?php if( $logo_white = Brk()->get_logo_white() ): ?>
                    <div class="brk-logo-overlap">
                        <img src="<?php echo esc_url( $logo_white ); ?>">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php echo esc_html( Brk()->get_name() ); ?>
            <?php endif; ?>
        </a>
    </span>
</div>