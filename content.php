<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<div class="featured-post">
				<?php _e( 'Featured post', 'fup' ); ?>
			</div>
		<?php
		endif;
		the_post_thumbnail();
		if ( is_single() ) : ?>
			<h1><?php the_title(); ?></h1>
		<?php
		else : ?>
			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php
					echo esc_attr( sprintf(
											__( 'Permalink to %s', 'fup' ),
											the_title_attribute( 'echo=0' )
											) );
					?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php
		endif; // is_single()

		if ( comments_open() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'fup' ) . '</span>', __( '1 Reply', 'fup' ), __( '% Replies', 'fup' ) ); ?>
			</div>
		<?php
		endif; // comments_open() ?>
	</header>
	<?php
	if ( is_search() ) : // Only display Excerpts for Search
		the_excerpt(); ?>
	<?php
	else :
		the_content( __(
					'Continue reading <span class="meta-nav">&rarr;</span>',
					'fup'
					) );
		wp_link_pages( array(
							  'before' => '<div class="page-links">'
							. __( 'Pages:', 'fup' ),
							  'after' => '</div>',
							  ) );
	endif; ?>
	<footer>
		<?php
		fup_entry_meta();
		edit_post_link(
						__( 'Edit', 'fup' ),
						'<span class="edit-link">',
						'</span>'
						);
		if ( is_singular()
		&& get_the_author_meta( 'description' )
		&& is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
			<section class="author-info">
				<div class="author-avatar">
					<?php
					echo get_avatar(
								get_the_author_meta( 'user_email' ),
								apply_filters( 'fup_author_bio_avatar_size',
								68
								) ); ?>
				</div>
				<div class="author-description">
					<h2><?php
						printf( __( 'About %s', 'fup' ), get_the_author() );
						?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
					<div class="author-link">
						<a href="<?php
							echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
							?>" rel="author">
							<?php
							printf(
									__(
										'View all posts by %s <span '
									  . 'class="meta-nav">&rarr;</span>',
										'fup'
										),
									get_the_author()
									); ?></a>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</footer>
</article>