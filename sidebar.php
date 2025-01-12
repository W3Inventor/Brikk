<?php if( is_active_sidebar( 'main_sidebar' ) and Brk()->get_meta('layout') == 'layout-sidebar' ): ?>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'main_sidebar' ); ?>
	</aside>
<?php endif; ?>
