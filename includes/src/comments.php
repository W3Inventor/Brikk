<?php

namespace Brikk\Includes\Src;

class Comments extends \Walker_Comment {

    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

        $commenter = wp_get_current_commenter();
        $show_pending_links = ! empty( $commenter['comment_author'] );

        if ( $commenter['comment_author_email'] ) {
            $moderation_note = esc_html__( 'Your comment is awaiting moderation.', 'brikk' );
        } else {
            $moderation_note = esc_html__( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'brikk' );
        }

        ?>
        <<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body<?php if( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) { echo ' brk-pingback'; } ?>">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <div class="brk-comment-meta">

                            <?php if( $comment->comment_type !== 'pingback' and $comment->comment_type !== 'trackback' ): ?>
                                <div class="brk-comment-avatar">
                                    <?php

                                        if ( 0 != $args['avatar_size'] ) {
                                            if( ! Brk()->user_has_gravatar( $comment->comment_author_email ) ) {
                                                echo Brk()->dummy('fas fa-user');
                                            }else{
                                                echo get_avatar( $comment, 58 );
                                            }
                                        }

                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="brk-comment-name">
                                <?php

                                    $comment_author = get_comment_author_link( $comment );

                                    if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
                                        $comment_author = get_comment_author( $comment );
                                    }

                                    printf( '<p class="brk--name">%s</p>', $comment_author );
                                    printf( '<p class="brk--date">%s</p>', esc_html( get_the_date() ) ); // get_time_elapsed_string

                                ?>
                            </div>
                        </div>
                    </div> <!-- .comment-author -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
                    <?php endif; ?>
                </footer> <!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div> <!-- .comment-content -->

                <?php
                if ( '1' == $comment->comment_approved || $show_pending_links ) {
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply"><i class="fas fa-reply"></i>',
                                'after'     => '</div>',
                            )
                        )
                    );
                }
                ?>
            </article> <!-- .comment-body -->
        <?php
    }

}
