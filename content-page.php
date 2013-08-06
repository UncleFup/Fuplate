<?php
/**
 * The template used for displaying page content in page.php
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h1><?php the_title(); ?></h1>
	</header>
		<?php the_content(); ?>
		<?php wp_link_pages( array(
									'before' => '<div class="page-links">'
											  . __( 'Pages:', 'fup' ),
									'after' => '</div>',
									) ); ?>
	<footer>
		<?php
		edit_post_link(
						__( 'Edit', 'fup' ),
						'<span class="edit-link">',
						'</span>'
						); ?>
	</footer>
</article>
