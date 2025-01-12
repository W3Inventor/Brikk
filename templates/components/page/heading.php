<?php global $brk_title, $brk_subtitle; ?>

<?php if( $brk_title ): ?>
    <header class="brk--heading">
        <h3 class="brk--title">
            <?php echo wp_kses( html_entity_decode( $brk_title ), Rz()->allowed_html() ); ?>
        </h3>
        <?php if( $brk_subtitle ): ?>
            <p><?php echo wp_kses( html_entity_decode( Rz()->format_url( $brk_subtitle ) ), Rz()->allowed_html() ); ?></p>
        <?php endif; ?>
    </header>
<?php endif; ?>
