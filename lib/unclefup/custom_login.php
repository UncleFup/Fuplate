<?php
/**
 * Register the URL for the custom login page
 * Lifted from: http://en.bainternet.info/2012/wordpress-easy-login-url-with-no-htaccess
 *
 * TODO Get slug automatically
 */
if ( current_theme_supports( 'custom_login' ) ):
	$fup_login_exists = get_page_by_title( 'Login' );
endif;

if ( isset( $fup_login_exists->ID ) ):
	//login url fix
	function fup_fix_login_url( $link ){
		global $login_exists;
		return str_replace(
							site_url( 'wp-login.php', 'login' ),
							site_url( 'login/', 'login' ),
							$link
							);
	}
	//register url fix
	function fup_fix_register_url( $link ){
		return str_replace(
							site_url(
									  'wp-login.php?action=register',
									  'login'
									  ),
							site_url( 'login/?do=register', 'login' ),
							$link
							);
	}
	//Site URL hack to overwrite register url
	function fup_fix_urls( $url, $path, $orig_scheme ){
		if ( $orig_scheme !== 'login' )
			return $url;
		if ( $path == 'wp-login.php?action=register' )
			return site_url( 'login/?do=register', 'login' );

		return $url;
	}
	//forgot password url fix
	function fup_fix_lostpass_url( $link ){
		return str_replace(
							site_url(
								      'wp-login.php?action=lostpassword',
								      'login'
								      ),
							site_url( 'login/?do=lostpassword', 'login' ),
							$link
							);
	}
	//logout url fix
	function fup_fix_logout_url( $link ){
		return str_replace(
							site_url(
								      'wp-login.php?action=logout',
								      'login'
								      ),
							site_url( 'login/?do=logout', 'login' ),
							$link
							);
	}

	add_filter( 'login_url',        'fup_fix_login_url' );
	add_filter( 'register',         'fup_fix_register_url' );
	add_filter( 'site_url',         'fup_fix_urls',10, 3 );
	add_filter( 'lostpassword_url', 'fup_fix_lostpass_url' );
	add_filter( 'logout_url',       'fup_fix_logout_url' );
endif;

/**
 * Creates login page
 *
 * @link http://wpsnipp.com/index.php/functions-php/create-page-on-theme-activation/
 */
function fup_create_login_page() {
	// Add a page for login if it doesn't exist

	if (is_admin() && isset($_GET['activated'])):
		$login_exists = get_page_by_title('Login');
		$login_page = array(
							'post_type'    => 'page',
							'post_title'   => 'Login',
							'post_content' => 'Login Page',
							'post_status'  => 'publish',
							'post_author'  => 1,
							);
		if(!isset($login_exists->ID)):
			$login_page_id = wp_insert_post($login_page);

			update_post_meta( $login_page_id, '_wp_page_template', 'login.php' );

		endif;
	endif;
}
