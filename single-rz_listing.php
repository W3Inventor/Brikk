<?php

get_header();

?>

<div class="brk-container">
	<main class="brk-main">

		<div class="brk-content">
			<?php
				while( have_posts() ): the_post();
					the_content();
				endwhile;
			?>
		</div>

	</main>
</div>

<?php get_footer();
