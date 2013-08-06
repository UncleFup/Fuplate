<article id="comment-<?php comment_ID(); ?>" class="comment">
    <div class="pull-left">
        <?php echo get_avatar( $comment, $size = '64', NULL, 'Avatar' ); ?>
    </div>
    <div class="media-body">
    <header class="comment-meta comment-author vcard">
        <h1 class="fn media-heading"><?php
                echo get_comment_author_link(); ?></h1>
        <time datetime="<?php echo
                comment_date( 'c' ); ?>"><a href="<?php
                    echo htmlspecialchars( get_comment_link( $comment->comment_ID) );
                    ?>"><?php printf(
                                      __( '%1$s', 'fup' ),
                                      get_comment_date(),
                                      get_comment_time()
                                    ); ?></a></time>
        <?php edit_comment_link(__('(Edit)', 'fup'), '', ''); ?>
    </header>
    <?php if ( $comment->comment_approved == '0' ) : ?>
        <section class="alert">
            <?php _e( 'This comment is awaiting moderation.', 'fup' ); ?>
        </section>
    <?php else: ?>
        <section class="comment-content comment media-body">
            <?php comment_text(); ?>
        </section>
    <?php endif; ?>
    <footer>
        <div class="reply">
            <?php
            if ( $comment->comment_approved != '0' ) :
                comment_reply_link( array_merge(
                                         $args,
                                         array(
                                            'depth' => $depth,
                                            'max_depth' => $args['max_depth']
                                        )));
            endif; ?>
        </div>
    </footer>
    </div>
</article>