<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 */

if ( is_active_sidebar( 'sidebar-1' ) ) :

	dynamic_sidebar( 'sidebar-1' );

endif;
