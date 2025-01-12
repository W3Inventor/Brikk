<main class="brk-main">
    <div class="brk-content">
        <article <?php post_class(); ?>>

            <?php $page_id = get_the_ID(); ?>

            <div class="brk-page-content">
                <?php the_content(); ?>
            </div>

            <?php wp_link_pages(); ?>

            <?php if( comments_open( $page_id ) ): ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        </article>
    </div>
</main>