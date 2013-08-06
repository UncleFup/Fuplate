<?php
/**
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
 */
function fup_language_attributes() {
	$attributes = array();
	$output = '';

	if ( function_exists( 'is_rtl' ) ):
		if ( is_rtl() == 'rtl' ):
			$attributes[] = 'dir="rtl"';
		endif;
	endif;

	$lang = get_bloginfo( 'language' );

	if ( $lang && $lang !== 'en-US' ):
		$attributes[] = "lang=\"$lang\"";
	else:
		$attributes[] = 'lang="en"';
	endif;

	$output = implode( ' ', $attributes );
	$output = apply_filters( 'fup_language_attributes', $output );

	return $output;
}
