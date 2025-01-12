<?php get_header(); ?>

<?php

$enable_page_modules = Brk()->get_meta('rz_enable_page_modules');

$is_explore = false;
if( function_exists('routiz') ) {
	$is_explore = Rz()->is_explore();
}

$is_account = ( function_exists('is_account_page') and is_account_page() );
$is_in_row = ( ! $enable_page_modules and ! $is_explore );

$show_title = true;
if( $is_explore ) {
	$show_title = false;
}

if( $is_account and is_user_logged_in() ) {
	$show_title = false;
}

$is_nav = false;
if( ! $is_explore ) {
	if( $is_account and is_user_logged_in() ) {
		$is_nav = true;
	}
}

if( Brk()->is_elementor() ) {
	$is_in_row = false;
}

?>

<?php if( $is_nav ): ?>
	<?php get_template_part('templates/account/dashboard/navigation'); ?>
<?php endif; ?>

<div class="brk-container">
	<?php if( $show_title ): ?>
		<?php get_template_part('templates/title'); ?>
	<?php endif; ?>
	<?php if( $is_in_row ): ?><div class="brk-row"><?php endif; ?>
		<?php if( $is_nav ): ?>
			<?php get_template_part('templates/account/dashboard/mobile/navigation'); ?>
		<?php endif; ?>
		<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'templates/content', 'page' );
			endwhile;
		?>
	<?php if( $is_in_row ): ?></div><?php endif; ?>
</div>

<?php if( $is_account ): ?>
	<?php Brk()->the_template('account/footer'); ?>
<?php endif; ?>

<?php get_footer();
