<?php
/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that
 * up. Inspired by
 * http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function fup_root_relative_url( $input ) {
	preg_match( '|https?://([^/]+)(/.*)|i', $input, $matches );

	if ( isset( $matches[1] )
		 && isset( $matches[2] )
		 && $matches[1] === $_SERVER['SERVER_NAME'] ):
		return wp_make_link_relative( $input );
	else:
		return $input;
	endif;

}

