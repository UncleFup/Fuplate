<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>
<div class="row">
	<section id="content" class="col-lg-8" role="main">
	<?php if ( have_posts() ) : ?>
		<header>
			<h1><?php printf(
							  __( 'Search Results for: %s', 'fup' ),
							  '<span>' . get_search_query() . '</span>'
							  ); ?></h1>
		</header>
		<?php
		fup_content_nav( 'nav-above' );
		/* Start the Loop */
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
		endwhile;

		fup_content_nav( 'nav-below' );

		else : ?>
			<header class="entry-header">
				<h1 class="entry-title"><?php
					_e( 'Nothing Found', 'fup' ); ?></h1>
			</header>
			<p><?php
				_e(
					'Sorry, but nothing matched your search criteria. '
				  . 'Please try again with some different keywords.',
					'fup'
					); ?></p>
					<?php get_search_form(); ?>

		<?php endif; ?>
	</section>
	<aside class="col-lg-4">
		<?php get_sidebar(); ?>
	</aside>
</div>
<?php get_footer(); ?>
