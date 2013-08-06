<?php
/**
 * URL rewriting
 *
 * Rewrites do not happen for multisite installations or child themes
 *
 * Rewrite:
 *   /wp-content/themes/themename/assets/css/ to /assets/css/
 *   /wp-content/themes/themename/assets/js/  to /assets/js/
 *   /wp-content/themes/themename/assets/img/ to /assets/img/
 *   /wp-content/plugins/                     to /plugins/
 *
 * If you aren't using Apache, try the alternate configurations below.
 *
 * For Ngingx, inlude these lines in your config before the PHP fastcgi
 * block:
 *     location ~ ^/(css|fonts|img|js)/(.*)$ {
 *         try_files $uri $uri/ /wp-content/themes/fuplate/assets/$1/$2;
 *     }
 *
 * For Lighttpd
 *
 * url.rewrite-once = (
 *   "^/css/(.*)$" => "/wp-content/themes/fuplate/assets/css/$1",
 *   "^/fonts/(.*)$" => "/wp-content/themes/fuplate/assets/fonts/$1",
 *   "^/img/(.*)$" => "/wp-content/themes/fuplate/assets/img/$1",
 *   "^/js/(.*)$" => "/wp-content/themes/fuplate/assets/js/$1",
 *   "^/plugins/(.*)$" => "/wp-content/plugins/$1"
 * )
 */
function fup_add_rewrites( $content ) {
    global $wp_rewrite;
    $fup_new_non_wp_rules = array(
  			'css/(.*)' => RELATIVE_THEME_PATH . '/assets/css/$1',
            'fonts/(.*)' => RELATIVE_THEME_PATH . '/assets/fonts/$1',
            'img/(.*)' => RELATIVE_THEME_PATH . '/assets/img/$1',
            'js/(.*)'  => RELATIVE_THEME_PATH . '/assets/js/$1',
    		'plugins/(.*)'    => RELATIVE_PLUGIN_PATH . '/$1',
  			);
    $wp_rewrite->non_wp_rules = array_merge(
                                            $wp_rewrite->non_wp_rules,
                                            $fup_new_non_wp_rules
                                            );
    return $content;
}

function fup_rewrite_urls( $content ) {
    if ( stristr( $content, RELATIVE_PLUGIN_PATH ) ):
        return str_replace(
                            '/' . RELATIVE_PLUGIN_PATH,
                            '/plugins',
                            $content
                            );
	else:
		return str_replace( '/' . RELATIVE_THEME_PATH, '', $content );
	endif;
}

