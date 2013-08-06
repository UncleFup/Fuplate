<?php
/**
 * Fuplate functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in
 * the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them
 * first in your child theme's functions.php file. The child theme's
 * functions.php file is included before the parent theme's file, so the
 * child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see
 * http://codex.wordpress.org/Plugin_API.
 */

/* ************************************************************************
 * Enable theme features
 */
add_theme_support( 'root-relative-urls' );       // Enable relative URLs
add_theme_support( 'rewrites' );                 // Enable URL rewrites
//   add_theme_support( 'bootstrap-top-navbar' );     // NOT CURRENTLY USED Enable Bootstrap's top navbar
add_theme_support( 'bootstrap-gallery' );        // Enable Bootstrap's thumbnails component on [gallery]
add_theme_support( 'jquery-cdn' );               // Enable to load jQuery from the Google CDN
add_theme_support( 'clean_up_head' );            // Enable clean up of head
add_theme_support( 'short_lang_attributes' );    // Shortens en-us to us and drops ltr
add_theme_support( 'sanitize_style_tags' );      // Remove irrelevant fluff from stylesheet links
add_theme_support( 'sanitize_body_classes' );    // Adds and removes classes from the body tag
add_theme_support( 'wrap_embedded_media' );      // Wraps embedded media as suggested by Readability
add_theme_support( 'thumb_class_4_attach' );     // Adds thumbnail class to attachments
add_theme_support( 'bootstrap_thumb_style' );    // Add Bootstrap thumbnail styling
add_theme_support( 'edit_avatar_class' );        // Adds a couple classes - including pull-left - to Avatars
add_theme_support( 'navbar_login_logout' );      // Adds support for a login/logout on the Navbar
add_theme_support( 'create_menu_widgets' );      // Creates menu widgets in each widget area, just to provide an idea, suggest you disable
add_theme_support( 'create_sample_menu' );       // Creates a sample menu and adds it to each menu widget (sort of), best disable before going wild
add_theme_support( 'custom_login' );		     // Use a custom login page
add_theme_support( 'minimal_theme_login' );		 // Whether to use a minimalist approach to the login theme
add_theme_support( 'use_dated_upload_folders' ); // Whether to use year-month folders in uploads folder
add_theme_support( 'move_uploads_2_uploads' );   // Move uploads folder to /uploads

/* ************************************************************************
 * Additional Settings
 */
/**
 * POST_EXCERPT_LENGTH
 */
define( 'POST_EXCERPT_LENGTH', 55 );	// Wordpress default is 55
/**
 * Sets up the content width value based on Bootstrap default container.
 */
if ( !isset( $content_width ) )
	$content_width = 940;



/* ************************************************************************
 * Fixes
 */
// Backwards compatibility for older than PHP 5.3.0
if ( !defined( '__DIR__' ) ) { define( '__DIR__', dirname( __FILE__ ) ) ; }


/*
 * Define some constants
 */

// First, get theme name
$theme_name = explode( '/themes/', get_template_directory() );

/**
 * RELATIVE_PLUGIN_PATH
 */
define( 'RELATIVE_PLUGIN_PATH',
	str_replace( home_url() . '/', '', plugins_url() ) );
/**
 * RELATIVE_CONTENT_PATH
 */
define( 'RELATIVE_CONTENT_PATH',
	str_replace( home_url() . '/', '', content_url() ) );
/**
 * RELATIVE_THEME_PATH
 */
define( 'RELATIVE_THEME_PATH',
	RELATIVE_CONTENT_PATH . '/themes/' . $theme_name[1] );


/* ************************************************************************
 * Load theme 'libraries'
 */

// Miscellaneous Functions
require_once( 'lib/unclefup/demo_widgets_and_menus.php' );
require_once( 'lib/unclefup/login_panels.php' );
require_once( 'lib/unclefup/nav_search_panel.php' );
require_once( 'lib/unclefup/menu_widget.php' );
require_once( 'lib/unclefup/custom_login.php' );
require_once( 'lib/unclefup/quote_metas.php' );
// Roots components
require_once( 'lib/shameless_lifts_from_roots/utility_functions.php' );
require_once( 'lib/shameless_lifts_from_roots/rewrites.php' );
require_once( 'lib/shameless_lifts_from_roots/root_relative_urls.php' );
require_once( 'lib/shameless_lifts_from_roots/clean_up_head.php' );
require_once( 'lib/shameless_lifts_from_roots/clean_style_tags.php' );
require_once( 'lib/shameless_lifts_from_roots/short_lang_attributes.php' );
require_once( 'lib/shameless_lifts_from_roots/cleanup_body_classes.php' );
require_once( 'lib/shameless_lifts_from_roots/media_wrap.php' );
require_once( 'lib/shameless_lifts_from_roots/add_thumb_class.php' );
require_once( 'lib/shameless_lifts_from_roots/bootstrap_thumb_style.php' );
require_once( 'lib/shameless_lifts_from_roots/comment_walker.php' );
require_once( 'lib/shameless_lifts_from_roots/avatar_classes.php' );
require_once( 'lib/shameless_lifts_from_roots/bootstrap_gallery_shortcode.php' );
require_once( 'lib/shameless_lifts_from_roots/jquery_fallback.php' );
// Register Custom Navigation Walker
// https://github.com/twittem/wp-bootstrap-navwalker
require_once( 'lib/wp_bootstrap_navwalker.php' );
// Adds support for a custom header image.
require( get_template_directory() . '/inc/custom-header.php' );



/* ************************************************************************
 * Theme functions
 */
/**
 * Sets up theme defaults and registers the various WordPress features that
 * Fuplate supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic
 *       feed links, custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 */
function fup_setup() {
	/*
	 * Makes Fuplate available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Uncle Fup, use a find and replace
	 * to change 'fup' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'fup', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor with editor-style.css to match
	 * the theme style.
	 *
	 * TODO Edit editor stylesheet.
	 */
	add_editor_style(get_bloginfo('url') . '/assets/css/editor-style.css');

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array(
											  'aside',
											  'image',
											  'link',
											  'quote',
											  'status',
											  ) );

	/*
	 * This theme uses wp_nav_menu() in one location. However, it is
	 * intended that you should be able to use more than one in multiple
	 * locations.
	 */
	register_nav_menus( array(
					'navbar'        => __( 'Navigation Bar', 'fup' ),
					'masthead'		=> __( 'Masthead Menu', 'fup' ),
					'sidebar'       => __( 'Sidebar Menu', 'fup' ),
					'left-column'   => __( 'Left Column Menu', 'fup' ),
					'center-column' => __( 'Center Column Menu', 'fup' ),
					'right-column'  => __( 'Right Column Menu', 'fup' ),
					'footer'        => __( 'Footer Menu', 'fup' ),
					) );

	/*
	 * This theme uses a custom image size for featured images, displayed
	 * on "standard" posts.
	 */
	add_theme_support( 'post-thumbnails' );
	// current width based on 8 columns
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

}
add_action( 'after_setup_theme', 'fup_setup' );

/**
 * Enqueues scripts and styles for front-end.
 */
function fup_scripts_styles() {
	global $wp_styles;





	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'fup-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/*
	 * translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'fup' ) ) {
		$subsets = 'latin,latin-ext';

		/*
		 * translators: To add an additional Open Sans character subset
		 * specific to your language, translate this to 'greek', 'cyrillic'
		 * or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x(
			'no-subset',
			'Open Sans font: add new subset (greek, cyrillic, vietnamese)',
			'fup'
			);

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style(
						  'fup-fonts',
						  add_query_arg(
				  	            $query_args,
				  	            "$protocol://fonts.googleapis.com/css" ),
						  array(),
						  null
						  );
	}

	/*
	 * Loads stylesheets
	 */
	// Bootstrap
	wp_enqueue_style(
				'bootstrap-css',
				get_template_directory_uri() . '/css/bootstrap.min.css',
				'',
				'3.0.0.rc1'
				);
	wp_enqueue_style(
			'glyphicons',
			get_template_directory_uri() . '/css/bootstrap-glyphicons.css',
			'',
			'1.0.0'
			);

	// Our main stylesheet, i.e. the place to start editing
	wp_enqueue_style(
			'fup_style',
			get_template_directory_uri() . '/css/style.css',
			array( 'bootstrap-css' ),
			filemtime( get_template_directory() . '/assets/css/style.css' )
			);

 	/*
 	 * Lifted from Roots theme.
	 *
	 * jQuery is loaded using the same method from HTML5 Boilerplate:
	 * Grab Google CDN's latest jQuery with a protocol relative URL; fallback
 	 * to local if offline
	 * It's kept in the header instead of footer to avoid conflicts with
	 * plugins.
	 */
	if ( !is_admin() && current_theme_supports( 'jquery-cdn' ) ) {
		wp_deregister_script( 'jquery' );
		/*
		 * Note that the lack of a protocol allows jQuery to be loaded over
		 * both http and https without any modifications.
		 */
		wp_enqueue_script(
			'jquery',
			'//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
			FALSE,
			NULL
			);
		add_filter(
					'script_loader_src',
					'fup_jquery_local_fallback',
					10,
					2
					);
	}

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular()
	&& comments_open()
	&& get_option( 'thread_comments' ) ):
		wp_enqueue_script( 'comment-reply' );
	endif;

	// Bootstrap
	wp_enqueue_script(
			'bootstrap-js',
			get_template_directory_uri() . '/js/vendor/bootstrap.min.js',
			FALSE,
			'3.0.0.rc1',
			TRUE
			);
	wp_enqueue_script(
			'fup_plugins',
			get_template_directory_uri() . '/js/plugins.js',
			FALSE,
			filemtime( get_template_directory() . '/assets/js/plugins.js' ),
			TRUE
			);
	wp_enqueue_script(
			'fup_main',
			get_template_directory_uri() . '/js/main.js',
			FALSE,
			filemtime( get_template_directory() . '/assets/js/main.js' ),
			TRUE
			);


	/*
	 * If you need an IE-specific stylesheet, use these functions, but the
	 * conditional classes offered at the head should allow you to contain
	 * any necessary fixes in your primary stylesheet.
	 *
	 * wp_enqueue_style()
	 * $wp_styles->add_data()
	 */
}
add_action( 'wp_enqueue_scripts', 'fup_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function fup_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ):
		$title = "$title $sep "
			   . sprintf( __( 'Page %s', 'fup' ), max( $paged, $page ) );
	endif;

	return $title;
}
add_filter( 'wp_title', 'fup_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 */
function fup_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'fup_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 */
function fup_widgets_init() {
/*
 * A BRIEF DISCOURSE ON UNCLE FUP'S HTML 5 SEMANTIC PHILOSOPHY
 *
 * I am going to stand by this until I read something that changes my mind
 * or someone convincingly argues to me a better concept. We should all
 * strive to grow. However, as someone who has largely been an independent
 * developer, I have two problems that limit my growth. First, a lack of
 * collaboration opportunity has limited my learning opportunities, and
 * I don't independently have time to read the wealth of articles
 * available. I do believe that semantics and accessibility are important,
 * although the latter has become increasingly more difficult for me to
 * remain current on, and will result in it being one of the last things
 * I approach with this toolkit.
 *
 * Now, concerning widgets, this is how I conceive of them. Each widget
 * is it's own section. Twenty Twelve wraps each one in an <aside>, and I
 * suppose that is correct. However, in my view, they are collectively an
 * aside concerning the "page structure".
 *
 * To my mind, a Web site is like a newspaper, and a web page is like
 * looking at an article on a newspaper page, such that you essentially
 * have a page within a page. Essentially, a web page is a "document"
 * containing structure, and thus you somewhat have two independent
 * structures: one pertaining to the article(s), and one to the overall
 * page. Sidebars, etc., are asides in themselves to the overall page, and
 * are a collection of widgets, that are usually each independent sections.
 * My choices below reflect this. The title of each section makes more
 * sense to me wrapped in an <h1> because its level is specific to that
 * section. Likewise, rather than using an <aside> to delineate each widget,
 * I chose to wrap each as a <section>. It just makes more semantic,
 * structural sense to me.
 *
 * I suppose each title could also be wrapped in <header> and <hgroup> as
 * well, but it seems superfluous markup to me.
 */
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'fup' ),
		'id'            => 'sidebar-1',
		'description'   => __(
							   'Appears on posts and pages except the '
							   . 'optional Front Page template, which has '
							   . 'its own widgets',
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'First Front Page Widget Area', 'fup' ),
		'id'            => 'sidebar-2',
		'description'   => __(
							   'Appears when using the optional Front Page'
							   . ' template with a page set as Static '
							   . 'Front Page',
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Second Front Page Widget Area', 'fup' ),
		'id'            => 'sidebar-3',
		'description'   => __(
							   'Appears when using the optional Front Page'
							   . ' template with a page set as Static '
							   . 'Front Page',
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Masthead Widget Area', 'fup' ),
		'id'            => 'masthead-1',
		'description'   => __(
							   'Conceived as an area for displaying ads.',
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'fup' ),
		'id'            => 'footer-1',
		'description'   => __(
							   'Conceived as an area for an add or other '
							   . 'content.',
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Lower Left Widget Area', 'fup' ),
		'id'            => 'lower-left',
		'description'   => __(
							   'It is common today to see the bottom of '
							   . 'a page divided into three columns. This '
							   . 'is intended to support that design '
							   . 'concept with widgets.' ,
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Lower Center Widget Area', 'fup' ),
		'id'            => 'lower-middle',
		'description'   => __(
							   'It is common today to see the bottom of '
							   . 'a page divided into three columns. This '
							   . 'is intended to support that design '
							   . 'concept with widgets.' ,
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Lower Right Widget Area', 'fup' ),
		'id'            => 'lower-right',
		'description'   => __(
							   'It is common today to see the bottom of '
							   . 'a page divided into three columns. This '
							   . 'is intended to support that design '
							   . 'concept with widgets.' ,
							   'fup'
							   ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

}
add_action( 'widgets_init', 'fup_widgets_init' );

if ( ! function_exists( 'fup_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 */
function fup_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) :
		if ( 'nav-above' == $html_id ): ?>
			<nav id="<?php echo $html_id; ?>">
				<h3 class="assistive-text"><?php
					_e( 'Post navigation', 'fup' ); ?></h3>
				<ul class="pager">
					<li class="previous"><?php
						next_posts_link(
							__( '<span class="meta-nav">&larr;</span> Older posts',
							'fup'
							) ); ?></li>
					<li class="next"><?php
						previous_posts_link(
							__( 'Newer posts <span class="meta-nav">&rarr;</span>',
							'fup'
							) ); ?></li>
				</ul>
			</nav>
		<?php
		else:
			// Drawn from Codex example

			$big = 999999999; // need an unlikely integer

			$pages = paginate_links( array(
							'base' => str_replace(
								   $big,
								   '%#%',
								   esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'end_size'     => 1,
							'mid_size'     => 2,
							'type'         => 'array',
							'next_text'    => __('Next'),
							'prev_text'    => __( 'Previous' ),
							'prev_next'    => TRUE,
							) );
			?>
			<nav role="navigation" class="text-center">
				<ul class="pagination">
					<?php
					foreach ( $pages as $tab ):
						if ( preg_match(
								'|<a class="prev page-numbers" href="(.*)">(.*)</a>|',
								$tab,
								$matches
								) ):
							echo '<li><a class="prev" href="' . $matches[1]
							   . '" title="';
							_e( 'Go to the previous page.', 'fup' );
							// use $matches[2] to put the text back in the link
							echo '"><span class="glyphicon glyphicon-backward">'
							   . '</span></a></li>';
						elseif ( preg_match(
									'|<a class="next page-numbers" href="(.*)">(.*)</a>|',
									$tab,
									$matches
									) ):
							echo '<li><a class="next" href="' . $matches[1]
							   . '" title="';
							_e( 'Go to the next page.', 'fup' );
							// $matches[2] to put the text back in the link
							echo '">'
							   . ' <span class="glyphicon glyphicon-forward">'
							   . '</span></a></li>';
						elseif ( '<span class="page-numbers dots">&hellip;</span>' == $tab ):
							echo '<li class="disabled"><span>&hellip;</span></li>';
						elseif ( preg_match(
									"|<(.*)'page-numbers current'>(.*)</span>|",
									$tab,
									$matches
									) ):
							echo '<li class="active"><span>' . $matches[2]
							   . '</span></li>';
						else:
							/**
							 * TODO Really tempted to clean-up Wordpress here,
							 * but not going to spend the time
							 */
							echo "<li>" . $tab . "</li>";
						endif;
					endforeach;
					?>
				</ul>
			</nav>
		<?php
		endif;
	endif;
}
endif;

if ( ! function_exists( 'fup_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own fup_comment(), and that function will be
 * used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * TODO Bothers me. Consider reworking markup.
 */
function fup_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'fup' ); ?> <?php comment_author_link();
		?> <?php edit_comment_link(
									__( '(Edit)', 'fup' ),
									'<span class="edit-link">',
									'</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						/*
						 * If current post author is also comment author,
						 * make it known visually.
						 */
						( $comment->user_id === $post->post_author )
							? '<span> ' . __( 'Post author', 'fup' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf(
								 __( '%1$s at %2$s', 'fup' ),
								 get_comment_date(),
								 get_comment_time()
								 )
					);
				?>
			</header><!-- .comment-meta -->
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php
					_e( 'Your comment is awaiting moderation.', 'fup' );
					?></p>
			<?php endif; ?>
			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link(
										 __( 'Edit', 'fup' ),
										 '<p class="edit-link">',
										 '</p>'
										 ); ?>
			</section>
			<div class="reply">
				<?php
				comment_reply_link( array_merge(
							$args,
							array(
								   'reply_text' => __( 'Reply', 'fup' ),
								   'after'      => ' <span>&darr;</span>',
								   'depth'      => $depth,
								   'max_depth'  => $args['max_depth']
								   ) ) ); ?>
			</div>
		</article>
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'fup_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags,
 * permalink, author, and date.
 *
 * Create your own fup_entry_meta() to override in a child theme.
 */
function fup_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'fup' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'fup' ) );

	$date = sprintf(
					 '<a href="%1$s" title="%2$s" rel="bookmark"><time '
		           . 'class="entry-date" datetime="%3$s">%4$s</time></a>',
					 esc_url( get_permalink() ),
					 esc_attr( get_the_time() ),
					 esc_attr( get_the_date( 'c' ) ),
					 esc_html( get_the_date() )
					 );

	$author = sprintf(
					   '<span class="author vcard"><a class="url fn n" '
					 . 'href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
					   esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					   esc_attr( sprintf(
										  __( 'View all posts by %s', 'fup' ),
										  get_the_author() ) ),
					   get_the_author()
					   );

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __(
							'Posted in %1$s and tagged %2$s'
						  . ' on %3$s<span class="by-author"> by %4$s'
						  . '</span>.',
						  'fup'
						  );
	} elseif ( $categories_list ) {
		$utility_text = __(
							'Posted in %1$s on %3$s<span '
						  . 'class="by-author"> by %4$s</span>.',
						  'fup'
						  );
	} else {
		$utility_text = __(
							'Posted on %3$s<span '
						  . 'class="by-author"> by %4$s</span>.',
						    'fup'
						    );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;





/** USING ROOTS VERSION
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
/*function fup_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'fup-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'fup_body_class' );*/



/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fup_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'fup_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fup_customize_preview_js() {
	wp_enqueue_script(
					   'fup-customizer',
					   get_template_directory_uri()
					 . '/js/theme-customizer.js',
					   array( 'customize-preview' ),
					   '20120827',
					   true
					   );
}
add_action( 'customize_preview_init', 'fup_customize_preview_js' );






// Enable the Navbar Login/Profile Panel
if ( current_theme_supports( 'navbar_login_logout' ) ):
	/**
	 * Configure admin bar for Bootstrap login
	 */
	if ( current_user_can( 'edit_posts' ) ):
		add_filter( 'show_admin_bar', '__return_true' );
	else:
		show_admin_bar( false );
	endif;

	add_action( 'wp_before_admin_bar_render','fup_remove_account' );
endif;








/*
 * Enable Roots niceness
 *
 * Code shamelessly lifted from Ben Word and Scott Walkinshaw's Roots
 * Theme. Modified and integrated here, with a smattering above.
 * The core lifted code can be found in an explicitly identified
 * directory under lib/.
 *
 */
// Enable URL rewriting for the following classes of links
if ( !is_multisite() && !is_child_theme() ):
	if ( current_theme_supports('rewrites')
		&& function_exists( 'fup_add_rewrites' )):
		add_action('generate_rewrite_rules', 'fup_add_rewrites');
	endif;

	if ( !is_admin() && current_theme_supports( 'rewrites' ) ):
		$tags = array(
						'plugins_url',
						'bloginfo',
						'stylesheet_directory_uri',
						'template_directory_uri',
						'script_loader_src',
						'style_loader_src'
						);

		add_filters( $tags, 'fup_rewrite_urls' );
	endif;
endif;

// If relative urls are appropriate, add them
/**
 * TODO Clean this up for readability
 */
function fup_enable_root_relative_urls() {
    return !( is_admin()
    	      || in_array( $GLOBALS['pagenow'],
    	      	           array(
    	      	           	      'wp-login.php',
    	      	           	      'wp-register.php'
    	      	           	      )
    	      	           )
    	      )
            && current_theme_supports('root-relative-urls');
}

if ( fup_enable_root_relative_urls() ) {
	$root_rel_filters = array(
								'attachment_link',
								'author_link',
								'bloginfo_url',
								'category_link',
								'comment_reply_link',
								'day_link',
								'get_comment_author_link',
								'get_comment_author_url_link',
								'get_comment_link',
								'get_pagenum_link',
								'login_url',
								'logout_url',
								'lostpassword_url',
								'month_link',
								'page_link',
								'post_link',
								'post_type_link',
								'register',
								'script_loader_src',
								'site_url',
								'style_loader_src',
								'tag_link',
								'the_author_posts_link',
								'the_content_more_link',
								'the_permalink',
								'the_tags',
								'walker_nav_menu_start_el',
								'wp_list_pages',
								'wp_list_categories',
								'year_link',
								);

	add_filters( $root_rel_filters, 'fup_root_relative_url' );
}

if (current_theme_supports( 'clean_up_head' ))
	add_action( 'init', 'fup_head_cleanup' );

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter( 'the_generator', '__return_false' );

if ( current_theme_supports('short_lang_attributes') )
	add_filter( 'language_attributes', 'fup_language_attributes' );

if ( current_theme_supports( 'sanitize_style_tags' ) )
	add_filter( 'style_loader_tag', 'fup_clean_style_tag' );

if ( current_theme_supports( 'sanitize_body_classes' ) )
	add_filter( 'body_class', 'fup_body_class' );

if ( current_theme_supports( 'wrap_embedded_media' ) )
	add_filter( 'embed_oembed_html', 'fup_embed_wrap', 10, 4 );

if ( current_theme_supports( 'thumb_class_4_attach' ) ):
	add_filter(
		'wp_get_attachment_link',
		'fup_attachment_link_class',
		10,
		1
		);
endif;

if ( current_theme_supports( 'bootstrap_thumb_style' ) )
	add_filter( 'img_caption_shortcode', 'fup_caption', 10, 3 );

if ( defined( 'POST_EXCERPT_LENGTH' )
	&& function_exists( 'fup_excerpt_length' )
	&& function_exists( 'fup_excerpt_more' ) ):
	add_filter( 'excerpt_length', 'fup_excerpt_length' );
	add_filter( 'excerpt_more', 'fup_excerpt_more' );
endif;

/**
 * Remove unnecessary self-closing tags
 */
function fup_remove_self_closing_tags( $input ) {
  return str_replace( ' />', '>', $input );
}
add_filter( 'get_avatar', 'fup_remove_self_closing_tags' ); 			// <img />
add_filter( 'comment_id_fields', 'fup_remove_self_closing_tags' ); 	// <input />
add_filter( 'post_thumbnail_html', 'fup_remove_self_closing_tags' ); 	// <img />

/**
 * Don't return the default description in the RSS feed if it hasn't
 * been changed
 */
function fup_remove_default_description( $bloginfo ) {
	$default_tagline = 'Just another WordPress site';
	return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
}
add_filter( 'get_bloginfo_rss', 'fup_remove_default_description' );

if (current_theme_supports( 'edit_avatar_class' ) )
	add_filter( 'get_avatar', 'fup_get_avatar' );

if ( current_theme_supports( 'bootstrap-gallery' ) ):
	remove_shortcode( 'gallery' );
	add_shortcode( 'gallery', 'fup_gallery' );
endif;





/**
 * What to Do On Theme Activation
 */
if ( current_theme_supports( 'move_uploads_2_uploads' ) ):
	add_action( 'after_switch_theme', 'fup_move_uploads' );
endif;

if ( current_theme_supports( 'custom_login' ) ):
	add_action( 'after_switch_theme', 'fup_create_login_page' );
endif;


if ( current_theme_supports( 'create_menu_widgets' ) ):
	add_action( 'after_switch_theme', 'fup_add_widget_to_bar' );
endif;

if ( current_theme_supports( 'create_sample_menu' ) ):
	add_action( 'after_switch_theme', 'fup_make_menu' );
endif;



