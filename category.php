<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>
<div id="row">
	<section id="content" class="category-page col-lg-8" role="main">
		<?php if ( have_posts() ) : ?>
			<header>
				<h1><?php printf( __(
									  'Category Archives: %s', 'fup' ),
									  '<span>'
									. single_cat_title( '', false )
									. '</span>'
									  ); ?></h1>
			<?php if ( category_description() ) : // Show an optional category description ?>
				<div><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile;

			fup_content_nav( 'nav-below' );
			?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</section>
	<aside class="col-lg-4">
		<?php get_sidebar(); ?>
	</aside>
</div>
<?php get_footer(); ?>
