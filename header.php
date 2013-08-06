<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till
 * <section id="main">
 */
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
/*
 * Make sure we are using the latest rendering mode of Internet Explorer
 */
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php wp_head(); ?>
<?php
/* Loads HTML5 JavaScript file to add support for HTML5 elements in older
 * IE versions.
 */
?>
<!--[if lt IE 9]>
<script src="<?php
echo get_template_directory_uri();
?>/js/vendor/html5shiv.js?ver=3.6" type="text/javascript"></script>
<script src="<?php
echo get_template_directory_uri();
?>/js/vendor/respond.min.js?ver=1.1.0" type="text/javascript"></script>
<![endif]-->

</head>
<body <?php body_class(); ?>>
	<a class="assistive-text" href="#content" title="<?php
        esc_attr_e( 'Skip to content', 'fup' ); ?>"><?php
        _e( 'Skip to content', 'fup' ); ?></a>
    <div class="container">

        <nav class="navbar">
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
	<header role="banner">
        <div id="background-container"></div>
        <?php if (is_home() || is_front_page()): ?>
            <div class="container">
        	    <div>
        		    <?php
                    $header_image = get_header_image();
		            if ( ! empty( $header_image ) ) : ?>
			            <a href="<?php echo esc_url( home_url( '/' ) );
                            ?>"><img src="<?php
                            echo esc_url( $header_image );
                            ?>" class="header-image" width="<?php
                            echo get_custom_header()->width;
                            ?>" height="<?php
                            echo get_custom_header()->height; ?>" alt=""></a>
		            <?php endif; ?>
                    <div class="page-header">
				    <h1 class="site-title"><a href="<?php
                        echo esc_url( home_url( '/' ) ); ?>" title="<?php
                        echo esc_attr( get_bloginfo( 'name', 'display' ) );
                        ?>" rel="home"><?php bloginfo( 'name' );
                        ?></a></h1>
				    <h2 class="site-description"><?php
                        bloginfo( 'description' ); ?></h2>
                    </div>
                </div>
            </div>
        <?php else:
            if ( is_active_sidebar( 'masthead-1' ) ) : ?>
                <div id="masthead-widgets" class="container">
                    <div class="row">
                        <?php dynamic_sidebar( 'masthead-1' ); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="container">
                <?php
                $header_image = get_header_image();
                if ( ! empty( $header_image ) ) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) );
                        ?>"><img src="<?php echo esc_url( $header_image );
                        ?>" class="header-image" width="<?php
                        echo get_custom_header()->width; ?>" height="<?php
                        echo get_custom_header()->height; ?>" alt="" /></a>
                <?php endif; ?>
                <h1 class="site-title"><a href="<?php
                    echo esc_url( home_url( '/' ) ); ?>" title="<?php
                    echo esc_attr( get_bloginfo( 'name', 'display' ) );
                    ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="site-description"><?php
                    bloginfo( 'description' ); ?></h2>
            </div>
        <?php endif; ?>
    </header>
    <div class="container">