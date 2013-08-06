<?php
/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */
class Fup_Walker_Comment extends Walker_Comment {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>
		<ol <?php comment_class('media unstyled comment-'
		                        . get_comment_ID()); ?>>
	<?php
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;
		echo '</ol>';
	}

	function start_el(
		               &$output,
		               $comment,
		               $depth = 0,
		               $args = array(),
		               $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		if ( !empty( $args['callback'] ) ):
			call_user_func( $args['callback'], $comment, $args, $depth );
			return;
		endif;

		extract( $args, EXTR_SKIP ); ?>
		<li id="li-comment-<?php
						comment_ID(); ?>" <?php
    comment_class( 'media comment-' . get_comment_ID() ); ?>>
		<?php
			switch ( $comment->comment_type ):

				case 'pingback':
				case 'trackback':
					?>
					<p <?php comment_class(); ?> id="comment-<?php
						comment_ID(); ?>">
						<?php _e( 'Pingback:', 'fup' ); ?> <?php
						comment_author_link(); ?> <?php
						edit_comment_link(
											__( '(Edit)', 'fup' ),
											'<span class="edit-link">',
											'</span>' ); ?></p>
					<?php
					break;
				default:
					include( locate_template( 'content-comment.php' ) );
					break;
			endswitch;
	}

	function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( !empty($args['end-callback']) ):
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			return;
		endif;
		switch ( $comment->comment_type ):

			case 'pingback':
			case 'trackback':
				echo '</li>';
			default:
				echo "</li>\n";
				break;
		endswitch;
	}
}
