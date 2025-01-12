<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php

		if( have_comments() ) :

			?><h2 class="comments-title">
				<?php
					$comment_count = get_comments_number();
					printf(
						esc_html( _nx( '%1$s comment', '%1$s comments', $comment_count, 'comments title', 'brikk' ) ),
						number_format_i18n( $comment_count )
					);
				?>
			</h2> <!-- .comments-title -->

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments([
						'walker' => new \Brikk\Includes\Src\Comments()
					]);
				?>
			</ol> <!-- .comment-list -->

			<?php

			the_comments_navigation();

			// if comments are closed and there are comments, let's leave a little note
			if( ! comments_open() ) :
				?><p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'brikk' ); ?></p><?php
			endif;

		endif; // check for have_comments().

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$args = [
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'brikk' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'fields' => apply_filters( 'brikk/comment_form', [
				'author' =>
					'<div class="brk-comment-reply-wrapper"><p class="comment-form-author">' .
					'<label for="author">' . esc_html__( 'Name', 'brikk' ) .
					( $req ? '<i class="required">*</i>' : '' ) . '</label> ' .
					'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' /></p>',

				'email' =>
					'<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'brikk' ) .
					( $req ? '<i class="required">*</i>' : '' ) . '</label> ' .
					'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' /></p>',

				'url' =>
					'<p class="comment-form-url"><label for="url">' .
					esc_html__( 'Website', 'brikk' ) . '</label>' .
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" /></p></div>'
			])
		];

		comment_form( $args );

	?>

</div> <!-- #comments -->
