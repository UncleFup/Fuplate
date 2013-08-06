<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 */

get_header(); ?>
<div class="row">
	<section id="content" role="main" class="col-lg-8">
		<?php
		while ( have_posts() ) : the_post();
			if ( has_post_thumbnail() ) : ?>
				<div class="entry-page-image">
					<?php the_post_thumbnail(); ?>
				</div><!-- .entry-page-image -->
			<?php
			endif;
			get_template_part( 'content', 'page' );

		endwhile; // end of the loop. ?>

	</section>
	<aside class="col-lg-4">
		<?php get_sidebar( 'front' ); ?>
	</aside>
</div>
<?php get_footer(); ?>