<?php
/**
 * Add and remove body_class() classes
 */
function fup_body_class( $classes ) {
	// Add post/page slug
	if ( is_single() || is_page() && !is_front_page() ):
		$classes[] = basename( get_permalink() );
	endif;

	// Remove unnecessary classes
	$home_id_class  = 'page-id-' . get_option( 'page_on_front' );
	$remove_classes = array(
								'page-template-default',
								$home_id_class
								);
	$classes        = array_diff( $classes, $remove_classes );

	return $classes;
}
