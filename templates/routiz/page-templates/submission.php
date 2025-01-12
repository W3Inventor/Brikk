<?php

use \Routiz\Inc\Src\Listing_Type\Action;

get_header();

global $rz_submission, $rz_explore;

$action_fields = Action::get_action_fields( $rz_submission->listing_type );
$actions = $rz_submission->listing_type->get_action();

?>

<div class="brk-submission rz-submission<?php if( $rz_submission->id ) { echo ' brk--is-sidebar'; } ?>">

	<?php if( $rz_submission->id ): ?>
		<div class="brk--sidebar">

			<div class="brk-site-logo">
	            <a href="<?php echo get_home_url(); ?>">
	                <?php if( $logo = Brk()->get_logo() ): ?>
	                    <img src="<?php echo esc_url( $logo ); ?>">
	                <?php else: ?>
	                    <span class="brk-site-title brk-font-heading">
	                        <?php echo esc_html( Brk()->get_name() ); ?>
	                    </span>
	                <?php endif; ?>
	            </a>
	        </div>

			<div class="rz-wizard">
			    <ul>

			        <?php if( $rz_submission->listing_type->has_plans() ): ?>
			            <li><?php esc_html_e( 'Select a Plan', 'brikk' ); ?></li>
			        <?php endif; ?>

			        <?php foreach( $rz_submission->tabs as $tab ): ?>
			            <li><?php echo esc_attr( $tab['title'] ); ?></li>
			        <?php endforeach; ?>

					<?php if( $action_fields->allow_pricing ): ?>
			            <li><?php esc_html_e( 'Pricing', 'brikk' ); ?></li>
			        <?php endif; ?>

					<?php if( $actions->has_reservation_section() ): ?>
						<li><?php esc_html_e( 'Reservation', 'brikk' ); ?></li>
			        <?php endif; ?>

			        <li><?php esc_html_e( 'Finish', 'brikk' ); ?></li>
			        <li><?php esc_html_e( 'Publish', 'brikk' ); ?></li>

			    </ul>
			</div>

		</div>
	<?php endif; ?>

	<div class="brk--content">
		<?php if( $rz_explore->total_types ): ?>
			<div class="brk--top">
				<?php if( $rz_submission->id ): ?>
					<span class="rz--image">
						<?php if( has_post_thumbnail( $rz_submission->listing_type->id ) ): ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $rz_submission->listing_type->id ) ); ?>
							<span class="rz--img" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);"></span>
						<?php else: ?>
							<?php $icon = Rz()->get_meta( 'rz_icon', $rz_submission->listing_type->id ); ?>
							<?php echo Rz()->dummy( $icon ? $icon : 'fas fa-toolbox', 100 ); ?>
						<?php endif; ?>
					</span>
					<h3 class="rz--name rz-ellipsis">
						<?php echo sprintf( esc_html__('Submit new %s', 'brikk'), $rz_submission->listing_type->get('rz_name') ); ?>
					</h3>
					<a href="<?php echo esc_url( $rz_explore->total_types > 1 ? Rz()->get_submission_page_url() : get_home_url() ); ?>" class="rz--exit">
						<?php esc_html_e('Exit', 'brikk'); ?>
					</a>
				<?php else: ?>
					<div class="brk-site-logo brk-text-center">
			            <a href="<?php echo get_home_url(); ?>">
			                <?php if( $logo = Brk()->get_logo() ): ?>
			                    <img src="<?php echo esc_url( $logo ); ?>">
			                <?php else: ?>
			                    <span class="brk-site-title brk-font-heading">
			                        <?php echo esc_html( Brk()->get_name() ); ?>
			                    </span>
			                <?php endif; ?>
			            </a>
			        </div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="brk--middle">
			<div class="brk--row">

				<?php if( $rz_explore->total_types ): ?>
					<?php if( $rz_submission->get_listing_types()->found_posts ): ?>
					    <?php if( $rz_submission->is_missing_type() ): ?>

							<?php Rz()->the_template('routiz/submission/listing-type'); ?>

					    <?php else: ?>

						    <div class="rz-submission-content">
						        <?php Rz()->the_template('routiz/submission/steps'); ?>
						    </div>

					    <?php endif; ?>
					<?php else: ?>
					    <div class="rz-submission-error rz-block">
					        <div class="rz--error">
					            <div class="rz--content">
					                <?php esc_html_e( 'No listing types were found', 'brikk' ); ?>
					            </div>
					        </div>
					    </div>
					<?php endif; ?>
				<?php else: ?>
					<div class="rz-submission-error rz-block">
						<div class="rz--error">
							<div class="rz--content">
								<?php esc_html_e( 'No listing types were found', 'brikk' ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php if( $rz_explore->total_types ): ?>
			<div class="brk--bottom">
				<?php if( $rz_submission->get_listing_types()->found_posts ): ?>
					<span class="rz--progress"></span>
					<div class="brk--cell brk--cell-back">
						<?php if( $rz_submission->id ): ?>
							<a href="#" class="rz-button rz-disabled" data-action="submission-back">
								<span class="fas fa-arrow-left rz-mr-1"></span>
								<span><?php esc_html_e('Back', 'brikk'); ?></span>
								<?php Rz()->preloader(); ?>
							</a>
						<?php endif; ?>
					</div>
					<?php if( $rz_submission->id ): ?>
						<div class="brk--cell brk--cell-steps">
							<div class="rz--steps">
								<span class="rz--steps-current">1</span>
								&nbsp;/&nbsp;
								<span class="rz--steps-total"></span>
							</div>
						</div>
					<?php endif; ?>
					<div class="brk--cell brk--cell-next">
						<a href="#" class="rz-button rz-button-accent" <?php echo is_user_logged_in() ? 'data-action="submission-continue"' : 'data-modal="signin"'; ?>>
							<span class="rz--text"><?php esc_html_e( 'Continue', 'brikk' ); ?></span>
		                    <span class="fas fa-arrow-right rz-ml-1"></span>
		                    <?php Rz()->preloader(); ?>
						</a>
					</div>
					<?php if( ! $rz_submission->id ): ?>
						<div class="brk--cell"></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer();
