<div class="brk--cell">
    <article class="brk--item<?php echo is_sticky() ? ' brk--sticky' : ''; ?>">

        <?php if( has_post_thumbnail() ): ?>
            <a href="<?php the_permalink(); ?>" class="brk--image">
                <?php the_post_thumbnail('large'); ?>
            </a>
        <?php endif; ?>

        <div class="brk--content">

            <?php if( get_the_title() !== '' ): ?>
                <h5 class="brk--title">
                    <a class="brk--name" href="<?php the_permalink(); ?>">
                        <?php if( get_the_title() !== '' ): ?>
                            <?php the_title(); ?>
                        <?php else: ?>
                            ( <?php esc_html_e('Empty', 'brikk'); ?> )
                        <?php endif; ?>
                    </a>
                </h5>
            <?php endif; ?>

            <div class="brk--meta">
                <?php $category = Brk()->get_post_first_category(); ?>
                <?php if( $category ): ?>
                    <div class="brk--meta-cell">
                        <a href="<?php echo esc_url( Brk()->get_post_first_category_url() ); ?>" class="brk--category brk-bg">
                            <span><?php echo esc_html( $category ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="brk--meta-cell">
                    <div class="brk--date">
                        <?php echo esc_html( get_the_date() ); // get_time_elapsed_string ?>
                    </div>
                </div>
            </div>

            <div class="brk--excerpt">
                <?php the_excerpt(); ?>
            </div>

            <p class="brk--more">
                <a href="<?php the_permalink(); ?>">
                    <?php esc_html_e( 'Continue reading', 'brikk' ); ?>
                </a>
            </p>

        </div>
    </article>
</div>