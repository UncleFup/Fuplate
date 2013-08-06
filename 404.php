<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>
	<section id="content" class="col-lg-8 col-offset-2 error404" role="main">
			<header class="error404 no-results not-found">
				<h1 class="entry-title"><?php
					_e(
						'This is somewhat embarrassing, isn&rsquo;t it?',
						'fup'
						); ?></h1>
			</header>
			<p><?php
				_e(
					'It seems we can&rsquo;t find what you&rsquo;re '
				  . 'looking for. Perhaps searching can help.',
				    'fup'
				    ); ?></p>
			<?php get_search_form(); ?>
	</section>
<?php get_footer(); ?>
