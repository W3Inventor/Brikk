<main class="brk-main">
    <div class="brk-content">
        <article <?php post_class(); ?>>
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
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