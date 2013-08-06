<?php
/**
 * Template Name: Login Page
 */
/**
 * Idea taken from: http://sysadmin.circularvale.com/server-config/modifying-the-existing-wordpress-loginregistrationlost-password-form/
 *
 * To use:
 * Create a new 'Page'
 */

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && ! is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect( set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) );
		exit();
	} else {
		wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		exit();
	}
}
/**
 * TODO Get rid of this
 */
$login_page = get_page_by_title('Login');


/**
 * Outputs the header for the login page.
 *
 * @uses do_action() Calls the 'login_head' for outputting HTML in the Log In
 *		header.
 * @uses apply_filters() Calls 'login_headerurl' for the top login link.
 * @uses apply_filters() Calls 'login_headertitle' for the top login title.
 * @uses apply_filters() Calls 'login_message' on the message to display in the
 *		header.
 * @uses $error The error global, which is checked for displaying errors.
 *
 * @param string $title Optional. WordPress Log In Page title to display in
 *		<title/> element.
 * @param string $message Optional. Message to display in header.
 * @param WP_Error $wp_error Optional. WordPress Error Object
 */
function login_header( $title = 'Log In', $message = '', $wp_error = '' ) {
	global $error, $interim_login, $current_site, $action;

	// Don't index any of these forms
	add_action( 'wp_head', 'wp_no_robots', '0' );

	if ( empty($wp_error) )
		$wp_error = new WP_Error();

	// Shake it!
	$shake_error_codes = array(
								'empty_password',
								'empty_email',
								'invalid_email',
								'invalidcombo',
								'empty_username',
								'invalid_username',
								'incorrect_password',
								);
	$shake_error_codes = apply_filters(
										'shake_error_codes',
										$shake_error_codes
										);

	if ( $shake_error_codes
	&& $wp_error->get_error_code()
	&& in_array( $wp_error->get_error_code(), $shake_error_codes ) ):
		add_action( 'wp_head', 'wp_shake_js', 12 );
	endif;

	/*
	 * Check if anything has been added to login_enqueue_scripts and move
	 * it to wp_enqueue_scripts if necessary. Correspongingly for login_head
	 */

	global $wp_filter;
	if ( isset( $wp_filter['login_enqueue_scripts'] ) ):
		foreach ( $wp_filter['login_enqueue_scripts']
			as $priority => $functions ):
			foreach ( $functions as $idx ):
				$function = $idx['function'];
				$accepted_args = $idx['accepted_args'];
				add_action(
							'wp_enqueue_scripts',
							$function,
							$priority,
							$accepted_args
							);
			endforeach;
		endforeach;
	endif;

	if ( isset( $wp_filter['login_head'] ) ):
		foreach ( $wp_filter['login_head'] as $priority => $functions ):
			foreach ( $functions as $idx ):
				$function = $idx['function'];
				$accepted_args = $idx['accepted_args'];
				add_action(
							'wp_head',
							$function,
							$priority,
							$accepted_args
							);
			endforeach;
		endforeach;
	endif;

	/*
	 * For the base theme, going to include the top navigation bar and
	 * nothing else on a minimalist appearance.
	 */
	if ( current_theme_supports( 'minimal_theme_login' ) ):
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php bloginfo('name'); ?> &rsaquo; <?php echo $title; ?></title>
<?php
/* Loads HTML5 JavaScript file to add support for HTML5 elements in older
 * IE versions.
*/
?>
<!--[if lt IE 9]>
<script src="<?php
echo get_template_directory_uri();
?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<a class="assistive-text" href="#content" title="<?php
        esc_attr_e( 'Skip to content', 'fup' ); ?>"><?php
        _e( 'Skip to content', 'fup' ); ?></a>
	<div class="navbar navbar-fixed-top navbar-inverse">
        <?php
        // Fix menu overlap bug..
        echo ( is_admin_bar_showing() )
            ? '<div style="min-height: 28px;"></div>' : NULL;?>
        <nav class="container">
            <button type="button" class="navbar-toggle"
                data-toggle="collapse" data-target=".top_navigation_bar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php
                echo esc_url( home_url( '/' ) ); ?>" title="<?php
                echo esc_attr( get_bloginfo( 'name', 'display' ) );
                ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            <div class="nav-collapse collapse navbar-responsive-collapse top_navigation_bar">
                <?php
                wp_nav_menu( array(
                            'menu'           => 'top_menu',
                            'theme_location' => 'navbar',
                            'depth'          => 3,
                            'container'      => false,
                            'menu_class'     => 'nav navbar-nav',
                            // If it doesn't exist, not going to use one
                            'fallback_cb'    => '',
                            //Process nav menu using our custom nav walker
                            'walker'         => new wp_bootstrap_navwalker()
                            )
                            );
                fup_search_panel();
                // Provide a login panel
                fup_navbar_login_panel();
                ?>
            </div>
        </nav>
    </div>
    <div class="container">
	<?php else:
	    get_header();
	endif;



	global $message, $messages, $form_errors;
	$message = apply_filters('login_message', $message);
	if ( !empty( $message ) )
		echo $message . "\n";

	// In case a plugin uses $error rather than the $wp_errors object
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( $wp_error->get_error_code() ) {
		$form_errors = '';
		$messages = '';
		foreach ( $wp_error->get_error_codes() as $code ) {
			$severity = $wp_error->get_error_data($code);
			foreach ( $wp_error->get_error_messages($code) as $error ) {
				if ( 'message' == $severity )
					$messages .= '	' . $error . "<br />\n";
				else
					$form_errors .= '	' . $error . "<br />\n";
			}
		}

	}
} // End of login_header()

/**
 * Outputs the footer for the login page.
 *
 * @param string $input_id Which input to auto-focus
 */
function login_footer($input_id = '') {
	global $interim_login;

	// Don't allow interim logins to navigate away from the page.
	if ( ! $interim_login ): ?>
		<div class="row"><p id="backtoblog" class="span12"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Are you lost?' ); ?>" class="btn btn-default"><?php printf( __( '&larr; Back to %s' ), get_bloginfo( 'title', 'display' ) ); ?></a></p></div>
	<?php endif; ?>

	</div>

	<?php if ( !empty($input_id) ) : ?>
	<script type="text/javascript">
	try{document.getElementById('<?php echo $input_id; ?>').focus();}catch(e){}
	if(typeof wpOnload=='function')wpOnload();
	</script>
	<?php endif; ?>

	<?php do_action('login_footer'); ?>
	<div class="clear"></div>

	<?php
	if ( current_theme_supports( 'minimal_theme_login' ) ):
?>	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="container">

			<div class="row">
				<div class="span12">
					<?php do_action( 'fup_credits' ); ?>
					<a href="<?php
						echo esc_url( __( 'http://wordpress.org/', 'fup' ) );
						?>" title="<?php
						esc_attr_e(
								'Semantic Personal Publishing Platform',
								'fup'
								); ?>"><?php
						printf( __(
									'Proudly powered by %s',
									'fup' ),
									'WordPress'
									); ?></a>
				</div>
			<div>
		</div>
	</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>

	<?php else:
		get_footer();
	endif;
}

function wp_shake_js() {
	if ( wp_is_mobile() )
		return;
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function s(id,pos){g(id).left=pos+'px';}
function g(id){return document.getElementById(id).style;}
function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
addLoadEvent(function(){ var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i='fup_login_panels';g(i).position='relative';shake(i,p,20);});
</script>
<?php
}

/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb, $current_site;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	else if ( is_wp_error($allow) )
		return $allow;

	$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty($key) ) {
		// Generate something random for a key...
		$key = wp_generate_password(20, false);
		do_action('retrieve_password_key', $user_login, $key);
		// Now insert the new md5 key into the db
		$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	}
	$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	$message .= '<' . network_site_url("login/?do=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset'), $blogname );

	$title = apply_filters('retrieve_password_title', $title);
	$message = apply_filters('retrieve_password_message', $message, $key);

	if ( $message && !wp_mail($user_email, $title, $message) )
		wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );

	return true;
}

/**
 * Retrieves a user row based on password reset key and login
 *
 * @uses $wpdb WordPress Database object
 *
 * @param string $key Hash to validate sending user's password
 * @param string $login The user login
 * @return object|WP_Error User's database row on success, error object for invalid keys
 */
function check_password_reset_key($key, $login) {
	global $wpdb;

	$key = preg_replace('/[^a-z0-9]/i', '', $key);

	if ( empty( $key ) || !is_string( $key ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	if ( empty($login) || !is_string($login) )
		return new WP_Error('invalid_key', __('Invalid key'));

	$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login));

	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	return $user;
}

/**
 * Handles resetting the user's password.
 *
 * @param object $user The user
 * @param string $new_pass New password for the user in plaintext
 */
function reset_password($user, $new_pass) {
	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);

	wp_password_change_notification($user);
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user( $user_login, $user_email ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}

//
// Main
//

$action = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login' ), true ) && false === has_filter( 'login_form_' . $action ) )
	$action = 'login';

nocache_headers();

header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined( 'RELOCATE' ) && RELOCATE ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$url = dirname( set_url_scheme( 'http://' .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) );
	if ( $url != get_option( 'siteurl' ) )
		update_option( 'siteurl', $url );
}

//Set a cookie now to see if they are supported by the browser.
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action( 'login_init' );
do_action( 'login_form_' . $action );

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
switch ($action) {

case 'postpass' :
	require_once ABSPATH . 'wp-includes/class-phpass.php';
	$hasher = new PasswordHash( 8, true );

	// 10 days
	setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( stripslashes( $_POST['post_password'] ) ), time() + 10 * DAY_IN_SECONDS, COOKIEPATH );

	wp_safe_redirect( wp_get_referer() );
	exit();

break;

case 'logout' :
	check_admin_referer('log-out');
	wp_logout();

	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : site_url();
	wp_safe_redirect( $redirect_to );
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :

	if ( $http_post ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'login/?checkemail=confirm';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));
	$redirect_to = apply_filters( 'lostpassword_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );

	do_action('lost_password');
	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

	fup_login_panel($pane="password");
	login_footer('user_login');
break;

case 'resetpass' :
case 'rp' :
	$user = check_password_reset_key($_GET['key'], $_GET['login']);

	if ( is_wp_error($user) ) {
		wp_redirect( site_url('login/?do=lostpassword&error=invalidkey') );
		exit;
	}

	$errors = new WP_Error();

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
		$errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

	do_action( 'validate_password_reset', $errors, $user );

	if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
		reset_password($user, $_POST['pass1']);
		login_header( __( 'Password Reset' ), '<p class="message reset-pass">' . __( 'Your password has been reset.' ) . ' <a href="' . esc_url( get_permalink($login_page->ID) ) . '">' . __( 'Log in' ) . '</a></p>' );
		login_footer();
		exit;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');

	login_header(__('Reset Password'), '<p class="message reset-pass">' . __('Enter your new password below.') . '</p>', $errors );

?>
<div class="row">
	<div class="span10 offset1">
		<form class="form-horizontal" name="resetpassform" id="resetpassform" action="<?php echo esc_url( site_url( 'login/?do=resetpass&key=' . urlencode( $_GET['key'] ) . '&login=' . urlencode( $_GET['login'] ), 'login_post' ) ); ?>" method="post">
			<fieldset>
				<legend>Reset Password</legend>
				<div class="control-group">
					<input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />
				<label class="control-label" for="pass1"><?php _e('New password') ?></label>
				<div class="controls">
					<input type="password" name="pass1" id="pass1" class="input" value="" autocomplete="off">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="pass2"><?php _e('Confirm new password') ?></label>
				<div class="controls">
					<input type="password" name="pass2" id="pass2" class="input" value="" autocomplete="off" />
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<div class="alert alert-error" id="pass-strength-result" class="hide-if-no-js">
						<?php _e('Strength indicator'); ?>
					</div>
					<p class="alert alert-info"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>
					<button type="submit" name="wp-submit" id="wp-submit" class="btn btn-success btn-large" value="<?php esc_attr_e('Reset Password'); ?>"><?php _e('Reset Password'); ?></button>
				</div>
			</div>
		</fieldset>
	</form>
	</div>
</div>

<p id="nav">
<a href="<?php echo esc_url( get_permalink($login_page->ID) ); ?>"><?php _e( 'Log in' ); ?></a>
<?php if ( get_option( 'users_can_register' ) ) : ?>
 | <a href="<?php echo esc_url( site_url( 'login/?do=register', 'login' ) ); ?>"><?php _e( 'Register' ); ?></a>
<?php endif; ?>
</p>

<?php
login_footer('user_pass');
break;

case 'register' :
	if ( is_multisite() ) {
		// Multisite uses wp-signup.php
		wp_redirect( apply_filters( 'wp_signup_location', network_site_url('wp-signup.php') ) );
		exit;
	}

	if ( !get_option('users_can_register') ) {
		wp_redirect( site_url('login/?registration=disabled') );
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$errors = register_new_user($user_login, $user_email);
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'login/?checkemail=registered';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	$redirect_to = apply_filters( 'registration_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );
	login_header(__('Registration Form'), '<p class="message register">' . __('Register For This Site') . '</p>', $errors);

	fup_login_panel("register");


	login_footer('user_login');
break;

case 'login' :
default:
	$secure_cookie = '';
	$interim_login = isset($_REQUEST['interim-login']);
	$customize_login = isset( $_REQUEST['customize-login'] );
	if ( $customize_login )
		wp_enqueue_script( 'customize-base' );

	// If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_user_by('login', $user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	$reauth = empty($_REQUEST['reauth']) ? false : true;

	// If the user was redirected to a secure login form from a non-secure admin page, and secure login is required but secure admin is not, then don't use a secure
	// cookie and redirect back to the referring non-secure admin page. This allows logins to always be POSTed over SSL while allowing the user to choose visiting
	// the admin via http or https.
	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) && !$reauth ) {
		if ( $interim_login ) {
			$message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
			login_header( '', $message ); ?>

			<?php if ( ! $customize_login ) : ?>
			<script type="text/javascript">setTimeout( function(){window.close()}, 8000);</script>
			<p class="alignright">
			<input type="button" class="button-primary" value="<?php esc_attr_e('Close'); ?>" onclick="window.close()" /></p>
			<?php endif; ?>
			</div>
			<?php do_action( 'login_footer' ); ?>
			<?php if ( $customize_login ) : ?>
				<script type="text/javascript">setTimeout( function(){ new wp.customize.Messenger({ url: '<?php echo wp_customize_url(); ?>', channel: 'login' }).send('login') }, 1000 );</script>
			<?php endif; ?>
			</body></html>
<?php		exit;
		}

		if ( ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
			// If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
			if ( is_multisite() && !get_active_blog_for_user($user->ID) && !is_super_admin( $user->ID ) )
				$redirect_to = user_admin_url();
			elseif ( is_multisite() && !$user->has_cap('read') )
				$redirect_to = get_dashboard_url( $user->ID );
			elseif ( !$user->has_cap('edit_posts') )
				$redirect_to = admin_url('profile.php');
		}
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) || $reauth )
		$errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if		( isset($_GET['loggedout']) && true == $_GET['loggedout'] )
		$errors->add('loggedout', __('You are now logged out.'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
		$errors->add('registerdisabled', __('User registration is currently not allowed.'));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
		$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
		$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
		$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');
	elseif	( $interim_login )
		$errors->add('expired', __('Your session has expired. Please log-in again.'), 'message');
	elseif ( strpos( $redirect_to, 'about.php?updated' ) )
		$errors->add('updated', __( '<strong>You have successfully updated WordPress!</strong> Please log back in to experience the awesomeness.' ), 'message' );

	// Clear any stale cookies.
	if ( $reauth )
		wp_clear_auth_cookie();

	login_header(__('Log In'), '', $errors);

	if ( isset($_POST['log']) )
		$user_login = ( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() ) ? esc_attr(stripslashes($_POST['log'])) : '';
	$rememberme = ! empty( $_POST['rememberme'] );

fup_login_panel();
?>


<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
<?php if ( $user_login || $interim_login ) { ?>
d = document.getElementById('user_pass');
d.value = '';
<?php } else { ?>
d = document.getElementById('user_login');
<?php if ( 'invalid_username' == $errors->get_error_code() ) { ?>
if( d.value != '' )
d.value = '';
<?php
}
}?>
d.focus();
d.select();
} catch(e){}
}, 200);
}

<?php if ( !$error ) { ?>
wp_attempt_focus();
<?php } ?>
if(typeof wpOnload=='function')wpOnload();
</script>

<?php
login_footer();
break;
} // end action switch

