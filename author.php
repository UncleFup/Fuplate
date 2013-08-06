<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>
<div class="row">
	<section id="content" class="col-lg-8 author-page" role="main">
		<?php

		if ( have_posts() ) :

			/*
			 * Queue the first post, that way we know what author we're
			 * dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop properly with a
			 * call to rewind_posts().
			 */
			the_post();
			?>

			<header>
				<h1><?php
					printf(
						__( 'Author Archives: %s', 'fup' ),
						'<span class="vcard"><a class="url fn n" href="'
					  . esc_url(
					    	get_author_posts_url(
					    		get_the_author_meta( "ID" )
					    		)
					    	)
					  . '" title="' . esc_attr( get_the_author() )
					  . '" rel="me">' . get_the_author()
					  . '</a></span>' ); ?></h1>
			</header>
			<?php
			/*
			 * Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

			fup_content_nav( 'nav-above' );

			/*
			 * If a user has filled out their description, show a bio on
			 * their entries.
			 */
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'fup_author_bio_avatar_size', 60 ) ); ?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2><?php printf( __( 'About %s', 'fup' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php fup_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</section>
	<aside class="col-lg-4">
		<?php
	 	get_sidebar();
	 	 ?>
	</aside>
</div>
<?php
get_footer();

