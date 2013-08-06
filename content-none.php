<?php
/**
 * The template for displaying a "No posts found" message.
 */
?>
<article id="post-0" class="post no-results not-found">
	<header>
		<h1><?php _e( 'Nothing Found', 'fup' ); ?></h1>
	</header>
	<p><?php
			_e(
				'Apologies, but no results were found. Perhaps searching '
			  . 'will help find a related post.',
				'fup'
				); ?></p>
	<?php get_search_form(); ?>
</article>
