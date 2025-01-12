<?php

$summary = Brk()->get_meta('rz_summary');

?>

<main class="brk-main">
    <div class="brk-content">
        <article <?php post_class('brk-post-content'); ?>>

            <?php if( has_post_thumbnail() ): ?>
                <div class="brk-featured">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <?php if( $summary ): ?>
                <div class="brk-summary brk-font-heading">
                    <?php echo do_shortcode( wpautop( $summary ) ); ?>
                </div>
            <?php endif; ?>

            <div class="brk-page-content">

                <?php the_content(); ?>

                <?php wp_link_pages(); ?>

            </div>

            <?php $post_tags = get_the_tags(); ?>
            <?php if( $post_tags ): ?>
                <div class="brk-tags">
                    <p><?php esc_html_e( 'Tags:', 'brikk' ); ?></p>
                    <ul>
                        <?php foreach( $post_tags as $tag ): ?>
                            <li>
                                <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">
                                    <?php echo esc_html( $tag->name );  ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php comments_template(); ?>

        </article>
    </div>
    <?php if( is_active_sidebar('sidebar') ): ?>
        <div class="brk-sidebar">
            <div class="">
                <?php dynamic_sidebar('sidebar'); ?>
            </div>
        </div>
    <?php endif; ?>
</main>