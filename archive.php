<?php get_header(); ?>

<div class="brk-container">
	<?php get_template_part('templates/title'); ?>
	<div class="brk-row">
		<main class="brk-main">
			<div class="brk-content">
				<?php if( have_posts() ): ?>
					<div class="brk-msnry">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/article-msnry' ); ?>
						<?php endwhile; ?>
					</div>
					<div class="brk-paging">
						<?php echo Brk()->pagination(); ?>
					</div>
				<?php else: ?>
					<?php get_template_part( 'templates/content-none' ); ?>
				<?php endif; ?>
			</div>
		</main>
	</div>
</div>

<?php get_footer();
