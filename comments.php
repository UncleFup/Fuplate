<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to fup_comment() which is
 * located in the functions.php file.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>
<?php if ( TRUE == FALSE ):?>
<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
		<h2>
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'fup' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol>
			<?php wp_list_comments( array( 'callback' => 'fup_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'fup' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'fup' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'fup' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'fup' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->
<?php endif; ?>

<?php // ROOTS VERSION // ?>
	<?php
	if ( post_password_required() ):
		return;
	endif;

	if ( have_comments() ): ?>
		<section id="comments">
			<h1><?php printf(
							  _n( 'One response to &ldquo;%2$s&rdquo;',
								  '%1$s responses to &ldquo;%2$s&rdquo;',
								  get_comments_number(),
								  'fup'
								  ),
							  number_format_i18n( get_comments_number() ),
							  get_the_title()
							  ); ?></h1>
			<ol class="media-list">
				<?php
				wp_list_comments( array( 'walker' => new Fup_Walker_Comment) );
				?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1
			&& get_option( 'page_comments' ) ) : ?>
				<nav>
					<ul class="pager">
						<?php
						if ( get_previous_comments_link() ) : ?>
							<li class="previous"><?php
								previous_comments_link(
											__(
												'&larr; Older comments',
												'fup'
												) ); ?></li>
				<?php
				endif;
				?>
				<?php
				if ( get_next_comments_link() ) : ?>
					<li class="next"><?php
						next_comments_link( __(
												'Newer comments &rarr;',
												'fup'
												) ); ?></li>
				<?php
				endif; ?>
			</ul>
		</nav>
		<?php
		endif;

		if ( !comments_open()
		&& !is_page()
		&& post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div class="alert">
				<?php _e('Comments are closed.', 'fup'); ?>
			</div>
		<?php
		endif; ?>
	</section>
<?php
endif;

if ( !have_comments()
&& !comments_open()
&& !is_page()
&& post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<section id="comments">
		<div class="alert">
			<?php _e( 'Comments are closed.', 'fup' ); ?>
		</div>
	</section><!-- /#comments -->
<?php
endif;

if ( comments_open() ) : ?>
	<section id="respond">
		<h1><?php comment_form_title(
									  __( 'Leave a Reply', 'fup' ),
									  __( 'Leave a Reply to %s', 'fup' ) );
			?></h1>
		<p class="cancel-comment-reply"><?php
			cancel_comment_reply_link(); ?></p>
		<?php
		if ( get_option( 'comment_registration' ) && !is_user_logged_in() ): ?>
			<p><?php
				printf(
						__(
							'You must be <a href="%s">logged in</a> to '
						  . 'post a comment.',
							'fup'),
						wp_login_url( get_permalink()
						) ); ?></p>
		<?php
		else : ?>
			<form action="<?php echo get_option( 'siteurl' );
				?>/wp-comments-post.php" method="post" id="commentform"
				class="form-horizontal">
				<?php
				if ( is_user_logged_in() ): ?>
					<p>
						<?php
						printf(
								__( 'Logged in as <a '
								  . 'href="%s/wp-admin/profile.php">%s</a>.',
								    'fup'
								    ),
								get_option( 'siteurl' ),
								$user_identity
								); ?>
						<a href="<?php
							echo wp_logout_url( get_permalink() );
							?>" title="<?php
							__( 'Log out of this account', 'fup');
							?>"><?php _e( 'Log out &raquo;', 'fup' );
							?></a>
					</p>
				<?php
				else : ?>
					<div class="form-group">
						<label for="author" class="col-lg-4 control-label"><?php
							_e( 'Name<br>', 'fup' );
							if ( $req ):
								_e( ' (required)', 'fup' );
							endif;
							?></label>
						<div class="col-lg-8">
							<input type="text" class="form-control"
								name="author" id="author" value="<?php
								echo esc_attr( $comment_author ); ?>" size="22"
								<?php
								if ( $req ) echo 'aria-required="true"';
								?> placeholder="<?php
								_e( 'e.g. John Doe', 'fup' ); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="control-label col-lg-4"><?php
							_e( 'Email (confidential)<br>', 'fup' );
							if ( $req ) _e( ' (required)', 'fup');
							?></label>
						<div class="col-lg-8">
							<input type="email" class="form-control"
								name="email" id="email" value="<?php
								echo esc_attr( $comment_author_email );
								?>" size="22" <?php
								if ( $req ) echo 'aria-required="true"';
								?> placeholder="<?php
								_e( 'e.g. address@example.com', 'fup' );
								?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-lg-4 control-label"><?php
							_e( 'Website', 'fup' ); ?></label>
						<div class="col-lg-8">
							<input type="url" class="form-control"
								name="url" id="url" value="<?php
								echo esc_attr( $comment_author_url );
								?>" size="22" placeholder="<?php
								_e( 'e.g. http://example.com', 'fup' ); ?>">
						</div>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="comment" class="control-label col-lg-4"><?php
						_e( 'Comment', 'fup' ); ?></label>
					<div class="col-lg-8">
						<textarea name="comment" id="comment"
							class="input-xlarge form-control" rows="5"
							aria-required="true" placeholder="<?php
							_e( 'Your wisdom or insight.', 'fup' );
							?>"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-offset-4 col-lg-8">
						<button name="submit" class="btn btn-primary"
							type="submit" id="submit"><?php
							 _e( 'Submit Comment', 'fup' ); ?></button>
					</div>
				</div>
				<?php comment_id_fields(); ?>
				<?php do_action( 'comment_form', $post->ID ); ?>
			</form>
		<?php endif; ?>
	</section><!-- /#respond -->
<?php endif; ?>

