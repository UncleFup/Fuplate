<?php
/**
 * The template for displaying posts in the Image post format
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	the_content( __(
					'Continue reading <span class="meta-nav">&rarr;</span>',
					'fup'
					) ); ?>
	<footer>
		<a href="<?php the_permalink(); ?>" title="<?php
			echo esc_attr(
						   sprintf( __( 'Permalink to %s', 'fup' ),
						   the_title_attribute( 'echo=0' )
						   ) ); ?>" rel="bookmark">
			<h1><?php the_title(); ?></h1>
			<h2><time class="entry-date" datetime="<?php
				echo esc_attr( get_the_date( 'c' ) ); ?>"><?php
				echo get_the_date(); ?></time></h2>
		</a>
		<?php
		if ( comments_open() ) : ?>
			<div class="comments-link">
				<?php
				comments_popup_link(
									 '<span class="leave-reply">'
								   . __( 'Leave a reply', 'fup' )
								   . '</span>',
									 __( '1 Reply', 'fup' ),
									 __( '% Replies', 'fup' )
									 ); ?>
			</div>
		<?php
		endif; // comments_open()
		edit_post_link(
						__( 'Edit', 'fup' ),
						'<span class="edit-link">',
						'</span>'
						); ?>
	</footer>
</article>