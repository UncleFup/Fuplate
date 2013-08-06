<?php
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
 function fup_head_cleanup() {
	// Originally from http://wpengineer.com/1438/wordpress-header/
	//remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

	global $wp_widget_factory;
	remove_action( 'wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style',
		) );

	add_filter( 'use_default_gallery_style', '__return_null' );

	if ( !class_exists( 'WPSEO_Frontend') ):
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'wp_head', 'fup_rel_canonical' );
	endif;
}

function fup_rel_canonical() {
	global $wp_the_query;

	if ( !is_singular() ):
		return;
	elseif ( !$id = $wp_the_query->get_queried_object_id() ):
		return;
	else:
		$link = get_permalink( $id );
		echo "\t<link rel =\"canonical\" href=\"$link\">\n";
	endif;
}
