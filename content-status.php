<?php
/**
 * The template for displaying posts in the Status post format
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<section class="media">
		<header class="pull-left">
			<p><?php
				echo get_avatar(
								 get_the_author_meta( 'ID' ),
								 '96',
								 '',
								 'Avatar'
				 				 );?></p>
			<h1><?php the_author(); ?></h1>
			<h2><a href="<?php the_permalink(); ?>" title="<?php
				echo esc_attr( sprintf(
										__( 'Permalink to %s', 'fup' ),
										the_title_attribute( 'echo=0' )
										) );
				?>" rel="bookmark"><?php
				echo get_the_date(); ?></a></h2>
		</header>
		<div class="media-body">
			<?php
			the_content( __(
					 'Continue reading <span class="meta-nav">&rarr;</span>',
					 'fup'
					 ) ); ?>
			<footer>
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
				<?php endif; // comments_open() ?>
				<?php
				edit_post_link(
								__( 'Edit', 'fup' ),
								'<span class="edit-link">',
								'</span>'
								); ?>
			</footer>
		</div>
	</section>
</article>
