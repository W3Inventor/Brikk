<?php get_header(); ?>

<div class="brk-container">
	<?php get_template_part('templates/title'); ?>
	<div class="brk-row">
		<main class="brk-main">
			<div class="brk-content">

				<div class="brk-404">
					<i class="fas fa-ghost"></i>
					<p><?php esc_html_e( 'The page you are looking for was not found.', 'brikk' ); ?></p>
				</div>

			</div>
		</main>
	</div>
</div>
<?php get_footer();
