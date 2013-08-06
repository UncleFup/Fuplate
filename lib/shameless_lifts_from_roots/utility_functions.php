<?php
/**
 * Utility functions
 */
function add_filters( $tags, $function ) {
    foreach( $tags as $tag ):
    	add_filter( $tag, $function );
    endforeach;
}

function is_element_empty( $element ) {
    $element = trim( $element );
    return empty( $element ) ? false : true;
}

function fup_move_uploads() {
	// Change Uploads folder to Media, lifted from Roots
	if ( !is_multisite() ):
	  update_option('upload_path', 'media');
	else:
	  update_option('upload_path', '');
	endif;

	if ( current_theme_supports( 'use_dated_upload_folders' ) ):
		update_option( 'uploads_use_yearmonth_folders', 0 );
	else:
		update_option( 'uploads_use_yearmonth_folders', 1 );
	endif;
}
