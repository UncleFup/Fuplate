<?php
/**
 * Removing logout/profile options from toolbar on front-end
 *
 * TODO Remove HTML comments. Here for the purpose of studying what happens
 */
function fup_remove_account(){
    global $wp_admin_bar;
    if ( is_admin() ):
    	/**
    	 * Uncomment and change Logged in as to replace "Howdy,"
         *
         * Method adapted from Take Control Of The WordPress Toolbar plugin
    	 */
		//$login_text = str_replace(
		//						  'Howdy,',
		//						  'Logged in as ',
		//						  $wp_admin_bar->get_node('my-account')->title
		//						 );
		//$wp_admin_bar->add_node( array(
		//								'id'    => 'my-account',
		//								'title' => $login_text,
		//								'meta'  => 	array(),
		//								) );
	else:
        //$wp_admin_bar->remove_node('top-secondary');
    	$wp_admin_bar->remove_node('my-account');
        $wp_admin_bar->remove_node('search');
	endif;
}

function fup_navbar_login_panel(){
	if ( is_user_logged_in() ):

    global $current_user;
    get_currentuserinfo(); ?>
    <ul class="pull-right nav navbar-nav">
		<li class="dropdown"><a href="<?php echo get_bloginfo( 'url' );
			?>/wp-admin/profile.php" data-toggle="dropdown" data-target="#"
			class="dropdown-toggle" title="<?php
			esc_attr_e( 'Logged in as:', 'fup' ); ?>">
			<span class="glyphicon glyphicon-user"></span> <?php
			echo $current_user->display_name ;
			?> <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li class="user-profile">
					<?php echo get_avatar(
						                   $current_user->ID,
						                   '64',
						                   '',
						                   'Avatar'
						                   );
					 ?><span class="display-name"><?php
					 echo $current_user->display_name ; ?></span>
				</li>
				<li>
					<a href="<?php echo get_bloginfo( 'url' );
						?>/wp-admin/profile.php" title="<?php
						esc_attr_e( 'Edit My Profile', 'fup' );
						?>"><?php _e( 'Edit My Profile', 'fup' );
						?></a>
				</li>
				<li>
					<a href="<?php
						echo wp_logout_url( $_SERVER['REQUEST_URI'] );
						?>" title="<?php
						esc_attr_e( 'Log Out', 'fup' ); ?>"><?php
						_e( 'Log Out', 'fup' ); ?></a>
				</li>
			</ul>
		</li>
	</ul>
<?php else: ?>
    <ul class="pull-right nav navbar-nav">
        <?php wp_register(
        					'<li>',
        					'</li><li class="divider-vertical"></li>',
        					TRUE
        					); ?>

        <li class="dropdown">
        	<a href="<?php
        		echo wp_login_url( $_SERVER['REQUEST_URI'] );?>"
        		data-toggle="dropdown" data-target="#"
        		class="dropdown-toggle" title="<?php
        		esc_attr_e( 'Login', 'fup' ); ?>"><?php
        		_e( 'Login', 'fup' ); ?></a>
            <div id="navbar-login" class="dropdown-menu">
            	<form name="loginform" id="nav-loginform" action="<?php
                	echo wp_login_url( $_SERVER['REQUEST_URI'] );
                	?>" method="post" class="form-horizontal">
					<div class="input-group">
						<i
							class="input-group-addon glyphicon glyphicon-user"></i><input
							type="text" id="user_login" name="log" value=""
							placeholder="Username" class="form-control">
					</div>
					<div class="input-group">
						<i
							class="input-group-addon glyphicon glyphicon-lock"></i><input
							type="password" id="user_pass" name="pwd"
							value="" placeholder="Password"
							class="form-control">
					</div>
					<div>
					<label for="rememberme" class="checkbox">
                        <input name="rememberme" type="checkbox"
                        id="rememberme" value="forever">
                        <?php _e( 'Remember Me', 'fup' ); ?>
                    </label></div>
					<button type="submit" name="wp-submit" id="wp-submit"
						class="btn btn-primary btn-block"
						value="Log In"><?php _e( 'Log In', 'fup' );
						?></button>
                    <input type="hidden" name="redirect_to" value="<?php
                    	echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="testcookie" value="1">
                    <p class="text-center">
                        <a href="<?php
                        	echo urlencode( wp_lostpassword_url( $_SERVER['REQUEST_URI'] ) );
                        	?>" title="<?php
                        	esc_attr_e(
                        		        'Password Lost and Found',
                        		        'fup'
                        		        );
							?>"><?php
                            _e( 'Lost your password?', 'fup' );
                            ?></a>
                    </p>
					<?php
					/**
					 * TODO Consider implementing with Facebook and Twitter
					 * before release.
					 */
/*

					<p class="text-center">or</p>
                    <input class="btn btn-primary btn-block" type="button"
                    	id="sign-in-google" value="Sign In with Google">
					<input class="btn btn-primary btn-block" type="button"
						id="sign-in-twitter" value="Sign In with Twitter">*/?>
							</form>
            </div>
        </li>
    </ul>
<?php endif;
}


function fup_login_panel( $pane="login" ){
	global $interim_login,
	       $user_login,
	       $rememberme,
	       $redirect_to,
	       $customize_login,
	       $user_email;

	$af = 'autofocus="autofocus" ';
	$autofocus = array(
						password     => '',
						registermail => '',
						registeruser => '',
						loginuser    => '',
						loginpass    => '',
						);

	if ( 'password' === $pane ):
		$autofocus['password'] = $af;
	elseif ( 'register' === $pane ):
		if ( !empty( $user_login ) ):
			$autofocus['registermail'] = $af;
		else:
			$autofocus['registeruser'] = $af;
		endif;
	else:
		if ( !empty( $user_login ) ):
			$autofocus['loginpass'] = $af;
		else:
			$autofocus['loginuser'] = $af;
		endif;
	endif;
	?>
	<div class="row" id="login_panel">
		<h3 id="main" class="col-lg-12">Have an account?</h3>
	</div>
	<div class="row" id="login_panels">
		<div class="col-lg-8 col-offset-2">
			<div class="tabbable" id="fup_login_panels">
				<ul class="nav nav-pills">
    				<li<?php
    					echo ($pane == 'login')
    						? ' class="active"' : NULL; ?>>
    					<a href="#login-form" data-toggle="tab" title="<?php
    						echo esc_attr_e( 'Login', 'fup' ); ?>"><?php
    						echo _e( 'Login', 'fup' ); ?></a>
    				</li>
					<?php if ( !$interim_login ): ?>
						<?php
						if ( isset($_GET['checkemail'])
							&& in_array(
						                 $_GET['checkemail'],
						                 array('confirm', 'newpass')
						                 ) ) :
						elseif ( get_option('users_can_register') ) : ?>
							<li<?php
		    					echo ($pane == 'register')
		    						? ' class="active"' : NULL; ?>>
		    					<a href="#register" data-toggle="tab"><?php
		    						_e( 'Register' ); ?></a></li>
							<li<?php
    							echo ($pane == 'password')
    								? ' class="active"' : NULL; ?>>
    							<a href="#lost-password" data-toggle="tab"
    								title="<?php
    								echo esc_attr_e(
    												 'Lost your password?',
    												 'fup'
    												 );
    								?>"><?php _e( 'Lost your password?' );
    								?></a>
    						</li>
						<?php else : ?>
							<li<?php
    							echo ($pane == 'password')
    								? ' class="active"' : NULL; ?>>
    							<a href="#lost-password" data-toggle="tab"
    								title="<?php
    								echo esc_attr_e(
    												 'Lost your password?',
    												 'fup'
    												 );
    								?>"><?php _e( 'Lost your password?' );
    								?></a>
    						</li>
						<?php endif;
						endif; ?>
				</ul>
				<div class="tab-content">
		    		<?php fup_login_pane( $pane, $autofocus );

					if ( !$interim_login ):
						if ( isset($_GET['checkemail'])
							&& in_array(
										 $_GET['checkemail'],
										 array('confirm', 'newpass') ) ):
						elseif ( get_option('users_can_register') ):
					    	fup_register_pane( $pane, $autofocus );
	    					fup_lost_pass_pane( $pane, $autofocus );
						else :
							fup_lost_pass_pane( $pane, $autofocus );
						endif;
					endif; ?>
		    	</div>
			</div>
		</div>
	</div>
<?php }


/**
 * Provides a login pane to the form. Theme is based on Twitter Bootstrap,
 * so we are making this form Bootstrap-py. If placing all of this in a
 * plugin, might consider doing the whole thing differently.
 */
function fup_login_pane( $pane = NULL, $autofocus = array() ) {
	global $message,
		   $messages,
		   $form_errors,
		   $interim_login,
		   $customize_login,
		   $redirect_to;
	?>
	<div class="tab-pane col-lg-11 col-offset-1<?php
		echo ($pane == 'login')? ' active' : NULL; ?>" id="login-form">
    	<form class="form-horizontal" name="loginform" id="loginform"
    		action="<?php echo esc_url( wp_login_url()); ?>" method="post">
    		<fieldset>
    		    <legend>Login</legend>
    		    <?php
    		    if ( $pane == 'login' ):

					if ( !empty($form_errors) )
						echo '<div class="alert alert-error">'
					         . apply_filters('login_errors', $form_errors)
					         . "</div>\n";

					if ( !empty($messages) )
						echo '<p class="message">'
					         . apply_filters('login_messages', $messages)
					         . "</p>\n";
				endif;
				?>
    		    <div class="form-group">
    		    	<label for="user_login" class="col-lg-3 control-label"><?php _e( 'Username', 'fup' ) ?></label>
				    <div class="col-lg-9">
    					<input <?php echo $autofocus['loginuser']; ?>type="text" name="log" id="user_login" value="<?php echo esc_attr( $user_login ); ?>" placeholder="Username" class="form-control">
    				</div>
  				</div>
				<div class="form-group">
					<label for="user_pass" class="control-label col-lg-3"><?php _e( 'Password' ) ?></label>
				    <div class="col-lg-9">
				    	<input <?php echo $autofocus['loginpass']; ?>type="password" name="pwd" id="user_pass" class="form-control" value="" placeholder="<?php echo esc_attr_e( 'Password', 'fup' ); ?>">
    				</div>
    			</div>
    			<div class="form-group">
    				<div class="col-lg-9 col-offset-3">
    					<div class="checkbox">
    						<label for="rememberme">
								<input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?>> <?php esc_attr_e( 'Remember Me', 'fup '); ?></label>
      					</div>
      				</div>
      			</div>
      			<div class="form-group">
      				<div class="col-lg-9 col-offset-3">
      					<!--do_action('login_form')-->
						<?php do_action('login_form'); ?>
						<!--end do_action-->
						<button type="submit" name="wp-submit"
							id="wp-submit"
							class="btn btn-success"><?php
							_e( 'Sign in', 'fup' ); ?></buttton>
						<?php
						if ( $interim_login ) { ?>
							<input type="hidden" name="interim-login"
								value="1">
						<?php } else { ?>
							<input type="hidden" name="redirect_to"
								value="<?php
								echo esc_attr($redirect_to); ?>">
						<?php } ?>
						<?php if ( $customize_login ) : ?>
							<input type="hidden" name="customize-login"
								value="1">
						<?php endif; ?>
						<input type="hidden" name="testcookie" value="1">
    				</div>
				</div>
			</fieldset>
		</form>
	</div>
	<?php
}

/**
 * Provides a registration pane
 */
function fup_register_pane( $pane = NULL, $autofocus = array() ){
	global $form_errors,
	       $message,
	       $messages,
	       $redirect_to,
	       $user_login,
	       $user_email;
	?>
	<div class="tab-pane col-lg-11 col-offset-1<?php
		echo ($pane == 'register')? ' active' : NULL; ?>" id="register">
    	<form class="form-horizontal" name="registerform" id="registerform"
    		action="<?php
    		echo esc_url( site_url('login/?do=register', 'login_post') );
    		?>" method="post">
			<fieldset>
				<legend><?php echo _e('Register'); ?></legend>
			   	<?php
			   	if ($pane == 'register'):
					if ( !empty($form_errors) )
						echo '<div class="alert alert-error">'
						   . apply_filters('login_errors', $form_errors)
						   . "</div>\n";
					if ( !empty($messages) )
						echo '<p class="message">'
						   . apply_filters('login_messages', $messages)
						   . "</p>\n";
				endif;
				?>
				<div class="form-group">
    		    	<label for="user_login" class="control-label col-lg-3"><?php _e('Username') ?></label>
				    <div class="col-lg-9">
				    	<input <?php echo $autofocus['registeruser'];
							?>type="text" name="user_login" id="user_login"
							class="form-control" value="<?php
							echo esc_attr( stripslashes( $user_login ) );
							?>" placeholder="<?php
							echo esc_attr_e( 'Preferred Username', 'fup' );
							?>">
    				</div>
  				</div>
				<div class="form-group">
					<label for="user_email" class="control-label col-lg-3"><?php
						_e( 'E-mail', 'fup' ); ?></label>
				    <div class="col-lg-9">
				    	<input <?php echo $autofocus['registermail'];
							?>type="text" name="user_email" id="user_email"
							class="form-control" value="<?php
							echo esc_attr( stripslashes( $user_email ) );
							?>" placeholder="<?php
							echo esc_attr_e('E-mail address', 'fup' ); ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-9 col-offset-3">
						<p class="alert alert-info">
							<?php
							_e( 'A password will be e-mailed to you.', 'fup' );
							?>
						</p>
    				</div>
    			</div>
    			<div class="form-group">
      				<div class="col-lg-9 col-offset-3">
      					<!--do_action('register_form')-->
						<?php do_action( 'register_form' ); ?>
						<!--end do_action-->
						<input type="hidden" name="redirect_to" value="<?php
						    echo esc_attr( $redirect_to ); ?>">
						<button class="btn btn-success"
							type="submit" name="wp-submit" id="wp-submit"
							class="button button-primary"
							value="<?php esc_attr_e( 'Register', 'fup' );
							?>"><?php echo _e( 'Register', 'fup' );
							?></button>
    				</div>
				</div>
			</fieldset>
		</form>
	</div>
<?php
}

/**
 * Pane for lost passwords
 */
function fup_lost_pass_pane( $pane = NULL, $autofocus = array() ){
	global $form_errors, $message, $messages, $redirect_to;
	?>
	<div class="tab-pane col-lg-11 col-offset-1<?php
		echo ($pane == 'password')? ' active' : NULL;
		?>" id="lost-password">
		<form class="form-horizontal" name="lostpasswordform"
			id="lostpasswordform" action="<?php
			echo esc_url(
			              site_url( 'login/?do=lostpassword',
			              'login_post'
			              ) ); ?>" method="post">
    	    <fieldset>
			    <legend><?php _e('Get New Password'); ?></legend>
    	    	<?php
    	    	if ($pane == 'password'):

					if ( !empty($form_errors) )
						echo '<div class="alert alert-error">'
						   . apply_filters('login_errors', $form_errors)
						   . "</div>\n";
					if ( !empty($messages) )
						echo '<p class="message">'
						   . apply_filters('login_messages', $messages)
						   . "</p>\n";
				endif;
				?>
				<div class="form-group">
					<label for="user_login" class="control-label col-lg-4"><?php
						_e( 'Username or E-mail:', 'fup' ); ?></label>
					<div class="col-lg-8">
						<input <?php
							echo $autofocus['password']; ?>type="text"
							name="user_login" id="user_login" class="form-control"
							value="<?php
							echo esc_attr($user_login);
							?>" placeholder="<?php
							esc_attr_e(
									    'Username or E-mail Address',
									    'fup');
									    ?>">
					</div>
				</div>
				<?php do_action('lostpassword_form'); ?>
				<div class="form-group">
					<input type="hidden" name="redirect_to" value="<?php
						echo esc_attr( $redirect_to ); ?>">
					<div class="col-offset-4 col-lg-8">
						<button class="btn btn-success"
							type="submit" name="wp-submit" id="wp-submit"
							class="button button-primary button-large"
							value="<?php
							esc_attr_e('Get New Password'); ?>"><?php
							_e('Get New Password'); ?></button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
<?php
}
