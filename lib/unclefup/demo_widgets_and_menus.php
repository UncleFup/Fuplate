<?php
/**
 * Miscellaneous Functions
 *
 * This file contains a number of miscellaneous functions. Started to provide
 * and alternative to the constants used in the Roots theme for the code
 * shamelessly lifted from there. Functions can pretty much be defined
 * anywhere.
 */


/**
 * Create a Default Menu
 *
 * The function creates a simplistic, default menu at the time of theme
 * activation for demonstration purposes.
 *
 * @link http://wordpress.stackexchange.com/questions/15455/how-to-hard-code-custom-menu-items
 */
function fup_make_menu(){
	// Get all of the menu locations
	$locations = get_theme_mod('nav_menu_locations');

	/*
	 * Create an inclusive navigation bar menu.
	 */
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Navbar Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Navbar Menu' );

		// Set up default menu items
    	wp_update_nav_menu_item(
    							 $menu_id,
    							 0,
    							 array(
									'menu-item-title'   =>  __('Home'),
									'menu-item-classes' => 'home',
									'menu-item-url'     => home_url( '/' ),
									'menu-item-status'  => 'publish',
									));

   		$postsID = wp_update_nav_menu_item(
   											$menu_id,
   											0,
   											array(
								'menu-item-title'   => __('Recent Posts'),
								'menu-item-classes' => 'recent-posts',
								'menu-item-url'     =>  '#',
								'menu-item-status'  => 'publish',
    							));

   		$recent_posts = wp_get_recent_posts();
    	foreach( $recent_posts as $post ):

	        wp_update_nav_menu_item(
            						 $menu_id,
	            					 0,
	            					 array(
					'menu-item-title'     => $post['post_title'],
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $post['ID'] ),
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $postsID,
   					));

		endforeach;

		$pages = get_pages(array( 'parent' => 0 ));

		foreach ( $pages as $page ):
			$pageID = wp_update_nav_menu_item(
											   $menu_id,
											   0,
											   array(
						'menu-item-title'   => $page->post_title,
						'menu-item-classes' => 'recent-posts',
						'menu-item-url'     =>  get_permalink( $page->ID ),
						'menu-item-status'  => 'publish',
    						));

			$subpages = get_pages( array( 'child_of' => $page->ID ) );

			foreach ( $subpages as $subpage ):
				wp_update_nav_menu_item(
										 $menu_id,
										 0,
										 array(
					'menu-item-title'     => $subpage->post_title,
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $subpage->ID ),
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $pageID,
   					));
			endforeach;
		endforeach;
	endif;

	// assign this bar to the top navigation bar
    $locations['navbar'] = ( empty( $locations['navbar'] ) )
    	? $menu_id : $locations['navbar'];

    /*
     * Create a menu for the "masthead" that only includes top level pages
     */
    // Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Masthead Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Masthead Menu' );

		// Set up default menu items
    	wp_update_nav_menu_item(
    							 $menu_id,
    							 0,
    							 array(
									'menu-item-title'   =>  __('Home'),
									'menu-item-classes' => 'home',
									'menu-item-url'     => home_url( '/' ),
									'menu-item-status'  => 'publish',
									));

		$pages = get_pages(array( 'parent' => 0 ));

		foreach ( $pages as $page ):
			$pageID = wp_update_nav_menu_item(
											   $menu_id,
											   0,
											   array(
						'menu-item-title'   => $page->post_title,
						'menu-item-classes' => 'recent-posts',
						'menu-item-url'     =>  get_permalink( $page->ID ),
						'menu-item-status'  => 'publish',
    						));

			$subpages = get_pages( array( 'child_of' => $page->ID ) );
			foreach ( $subpages as $subpage ):
				wp_update_nav_menu_item(
										 $menu_id,
										 0,
										 array(
					'menu-item-title'     => $subpage->post_title,
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $subpage->ID ),
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $pageID,
   					));
			endforeach;
		endforeach;
	endif;

	$locations['masthead'] = ( empty ( $locations['masthead'] ) )
		? $menu_id : $locations['masthead'];

	/*
	 * Create a sidebar menu that focuses on posts and comments.
	 */
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Sidebar Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Sidebar Menu' );

		// Set up default menu items
    	$postsID = wp_update_nav_menu_item(
   											$menu_id,
   											0,
   											array(
								'menu-item-title'   => __('Recent Posts'),
								'menu-item-classes' => 'recent-posts',
								'menu-item-url'     =>  '#',
								'menu-item-status'  => 'publish',
    							));

   		$recent_posts = wp_get_recent_posts();
    	foreach( $recent_posts as $post ):

	        wp_update_nav_menu_item(
            						 $menu_id,
	            					 0,
	            					 array(
					'menu-item-title'     => $post['post_title'],
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $post['ID'] ),
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $postsID,
   					));

		endforeach;

		$comments = get_comments( array( 'number' => 10, ) );
		$commentsID = wp_update_nav_menu_item(
											   $menu_id,
											   0,
											   array(
							'menu-item-title'   => __( 'Recent Comments' ),
							'menu-item-classes' => 'recent-comments',
							'menu-item-url'     => '#',
							'menu-item-status'  => 'publish',
						    ));
		foreach ( $comments as $comment ):
			wp_update_nav_menu_item(
            						 $menu_id,
	            					 0,
	            					 array(
				'menu-item-title'     => $comment->comment_content,
				'menu-item-classes'   => 'recent-comments',
				'menu-item-url'       =>  get_permalink( $comment->comment_ID ),
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $commentsID,
				));
		endforeach;

	endif;

	// assign this bar to the sidebar location
    $locations['sidebar'] = ( empty( $locations['sidebar'] ) )
    	? $menu_id : $locations['sidebar'];




    /*
     * Create a menu for the left column that only includes top level pages
     */
    // Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Left Column Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Left Column Menu' );

		// Set up default menu items
		$pages = get_pages( array( 'parent' => 0 ) );

		foreach ( $pages as $page ):
			$pageID = wp_update_nav_menu_item(
											   $menu_id,
											   0,
											   array(
						'menu-item-title'   => $page->post_title,
						'menu-item-classes' => 'recent-posts',
						'menu-item-url'     =>  get_permalink( $page->ID ),
						'menu-item-status'  => 'publish',
    						));
		endforeach;
	endif;

	$locations['left-column'] = ( empty( $locations['left-column'] ) )
		? $menu_id : $locations['left-column'];

	/*
	 * Create a center column menu that focuses on posts.
	 */
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Center Column Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Center Column Menu' );

		// Set up default menu items
   		$recent_posts = wp_get_recent_posts();
    	foreach( $recent_posts as $post ):

	        wp_update_nav_menu_item(
            						 $menu_id,
	            					 0,
	            					 array(
					'menu-item-title'     => $post['post_title'],
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $post['ID'] ),
					'menu-item-status'    => 'publish',
   					));

		endforeach;

	endif;

	// assign this bar to the sidebar location
    $locations['center-column'] = ( empty( $locations['center-column'] ) )
    	? $menu_id : $locations['center-column'];

	/*
	 * Create a menu that focuses on comments for the right column.
	 */
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Right Column Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Right Column Menu' );

		// Set up default menu items
		$comments = get_comments( array( 'number' => 10, ) );

		foreach ( $comments as $comment ):
			wp_update_nav_menu_item(
            						 $menu_id,
	            					 0,
	            					 array(
				'menu-item-title'     => $comment->comment_content,
				'menu-item-classes'   => 'recent-comments',
				'menu-item-url'       =>  get_permalink( $comment->comment_ID ),
				'menu-item-status'    => 'publish',
				));
		endforeach;

	endif;

	// assign this bar to the sidebar location
    $locations['right-column'] = ( empty( $locations['right-column'] ) )
    	? $menu_id : $locations['right-column'];



    /*
	 * Create a posts navigation menu for the footer.
	 */
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( 'Fuplate Footer Menu' );

	// If it doesn't exist, let's create it.
	if( !$menu_exists ):
    	$menu_id = wp_create_nav_menu( 'Fuplate Footer Menu' );

		// Set up default menu items
    	wp_update_nav_menu_item(
    							 $menu_id,
    							 0,
    							 array(
									'menu-item-title'   =>  __('Home'),
									'menu-item-classes' => 'home',
									'menu-item-url'     => home_url( '/' ),
									'menu-item-status'  => 'publish',
									));

   		$postsID = wp_update_nav_menu_item(
   											$menu_id,
   											0,
   											array(
								'menu-item-title'   => __('Recent Posts'),
								'menu-item-classes' => 'recent-posts',
								'menu-item-url'     =>  '#',
								'menu-item-status'  => 'publish',
    							));

   		$pages = get_pages( array( 'parent' => 0 ) );
		foreach ( $pages as $page ):
			$pageID = wp_update_nav_menu_item(
											   $menu_id,
											   0,
											   array(
						'menu-item-title'   => $page->post_title,
						'menu-item-classes' => 'recent-posts',
						'menu-item-url'     =>  get_permalink( $page->ID ),
						'menu-item-status'  => 'publish',
    						));

			$subpages = get_pages( array( 'child_of' => $page->ID ) );

			foreach ( $subpages as $subpage ):
				wp_update_nav_menu_item(
										 $menu_id,
										 0,
										 array(
					'menu-item-title'     => $subpage->post_title,
					'menu-item-classes'   => 'recent-posts',
					'menu-item-url'       =>  get_permalink( $subpage->ID ),
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $pageID,
   					));
			endforeach;
		endforeach;
	endif;

	// assign this bar to the top navigation bar
    $locations['footer'] = ( empty( $locations['footer'] ) )
    	? $menu_id : $locations['footer'];




    // store the assigned menu locations
    set_theme_mod( 'nav_menu_locations', $locations );


}


/**
 * Create a Menu Widget
 *
 * Function is used to create menu widgets automatically on theme
 * activation.
 */
function fup_add_menu_widget( $title, $region=FALSE ) {
	$option_exists = get_option( 'widget_fup_menu_widget' );
	if ( empty( $option_exists )):
		$widget_count = 1;
		$widget = array();
	else:
		$widget_count = max( array_keys( $option_exists ) ) + 1;
		$widget = $option_exists;
	endif;

	$widget['_multiwidget'] = 1;


    $widget[ $widget_count ] = array(
    		                           'title' => $title,
    		                           'menu_class' => NULL,
    	    	                       'menu_id' => NULL,
    	        	                   'before' => NULL,
    	                               'after' => NULL,
    	               	               'link_before' => NULL,
    	                   	           'link_after' => NULL,
    	                       	       'depth' => NULL,
    	                           	   'walker' => NULL,
    	                           		);
    if ( 'footer' == $region ):
    	$widget[ $widget_count ]['navbar'] = 'fixed-to-bottom';
    	$widget[ $widget_count ]['responsive'] = 'yes';
    elseif ( 'masthead' == $region ):
    	$widget[ $widget_count ]['navbar'] = 'static';
    	$widget[ $widget_count ]['responsive'] = 'yes';
    endif;

    update_option( 'widget_fup_menu_widget', $widget );

    return $widget_count;
}

/**
 * Auto-add Widgets to Widget Areas
 *
 * This function is used to automatically add menu widgets to widget areas
 * when the theme is activated.
 */
function fup_add_widget_to_bar() {
	$widget_areas = array(
					'sidebar-1'    => 'Primary Sidebar Links',
					'sidebar-2'    => 'Front Page, First Sidebar Links',
					'sidebar-3'    => 'Front Page, Second Sidebar Links',
					'masthead-1'   => 'Masthead',
					'footer-1'     => 'Footer Navigation',
					'lower-left'   => 'Pages',
					'lower-middle' => 'Recent Posts',
					'lower-right'  => 'Recent Comments',
				    );
	$sidebars_widgets = $old_ones = get_option( 'sidebars_widgets' );


	foreach ( $widget_areas as $area => $title ):
		if ( !isset( $sidebars_widgets[ $area ] ) ):
			$sidebars_widgets[ $area ] = array();
			if ( 'masthead-1' == $area ):
				$count = fup_add_menu_widget( $title, 'masthead' );
			elseif ( 'footer-1' == $area ):
				$count = fup_add_menu_widget( $title, 'footer' );
			else:
				$count = fup_add_menu_widget( $title );
			endif;
			$sidebars_widgets[ $area ][0] = 'fup_menu_widget' . '-' . $count;
		else:
			$widget_present = FALSE;
			foreach ( $sidebars_widgets[ $area ] as $key => $widget ):

				$widget_present =  strpos( $widget, 'fup_menu_widget' );

			endforeach;
			if ( 0 !== $widget_present ):
				if ( 'masthead-1' == $area ):
					$count = fup_add_menu_widget( $title, 'masthead' );
				elseif ( 'footer-1' == $area ):
					$count = fup_add_menu_widget( $title, 'footer' );
				else:
					$count = fup_add_menu_widget( $title );
				endif;
			    $sidebars_widgets[ $area ][] = 'fup_menu_widget'
			                                 . '-' . $count;
			endif;
		endif;
	endforeach;
	$sidebars_widgets['array_version']++;
	update_option( 'sidebars_widgets', $sidebars_widgets );
}





