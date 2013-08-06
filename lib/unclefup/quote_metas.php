<?php
/**
 * Adds meta boxes to posts when selecting quote post format.
 *
 */
// Add the Meta Box
function fup_add_quote_meta() {
    add_meta_box(
        'fup-quote-citation', // $id
        'Citation Details', // $title
        'show_fup_quote_author', // $callback
        'post', // $page
        'side', // $context
        'high' // $priority
        );

}
add_action('add_meta_boxes', 'fup_add_quote_meta');

// The Event Location Metabox

function show_fup_quote_author() {
	global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="fup_quotes" id="fup_quotes_noncename" value="' .
	wp_create_nonce( 'add_quote_citations', 'fup_quotes' ) . '" />';
//	wp_create_nonce( 'add_quote_citations', 'fup_quotes' ) ;

	// Get the location data if its already been entered
	$author    = get_post_meta( $post->ID, '_fup_quote_author',    true );
	$work      = get_post_meta( $post->ID, '_fup_quote_work',      true );
	$link      = get_post_meta( $post->ID, '_fup_quote_link',      true );
	$date      = get_post_meta( $post->ID, '_fup_quote_date',      true );
	$character = get_post_meta( $post->ID, '_fup_quote_character', true );
	$blurb     = get_post_meta( $post->ID, '_fup_quote_blurb',     true );

	// Echo out the field
	echo '<label for="fup_quote_author">Author: ';
	echo '<input id="fup_quote_author" type="text" name="_fup_quote_author"'
	   . ' value="' . $author  . '" class="widefat" /></label>';
	echo '<label for="fup_quote_work">Work cited: ';
	echo '<input id="fup_quote_work" type="text" name="_fup_quote_work" '
	   . 'value="' . $work  . '" class="widefat" /></label>';
	echo '<label for="fup_quote_link">Link to work: ';
	echo '<input id="fup_quote_link" type="text" name="_fup_quote_link" '
	   . 'value="' . $link  . '" class="widefat" /></label>';
	echo '<label for="fup_quote_date">Published (YYYY-MM-DD): ';
	echo '<input id="fup_quote_date" type="text" name="_fup_quote_date" '
	   . 'value="' . $date  . '" class="widefat" /></label>';
	echo '<label for="fup_quote_character">Character: ';
	echo '<input id="fup_quote_character" type="text" '
	   . 'name="_fup_quote_character" value="' . $character
	   . '" class="widefat" /></label>';
	echo '<label for="fup_quote_blurb">Additional info: ';
	echo '<input id="fup_quote_blurb" type="text" name="_fup_quote_blurb" '
	   . 'value="' . $blurb  . '" class="widefat" /></label>';

}

// Save the Metabox Data

function save_fup_quote_author($post_id, $post) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !empty( $_POST['_fup_quote_author'] )
	|| !empty( $_POST['_fup_quote_work'] )
	|| !empty( $_POST['_fup_quote_link'] )
	|| !empty( $_POST['_fup_quote_date'] )
	|| !empty( $_POST['_fup_quote_character'] )
	|| !empty( $_POST['_fup_quote_blurb'] ) ):

		if ( check_admin_referer('add_quote_citations','fup_quotes') ):


			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ) ) return FALSE;

			$fields = array(
							 '_fup_quote_author',
							 '_fup_quote_work',
							 '_fup_quote_link',
							 '_fup_quote_date',
							 '_fup_quote_character',
							 '_fup_quote_blurb',
						 	);
			foreach ( $fields as $field ):
				if ( !isset( $_POST[ $field ] ) || empty( $_POST[ $field ] ) ):
					delete_post_meta( $post->ID, $field );
				else:
					add_post_meta( $post->ID, $field, $_POST[ $field ], true )
					|| update_post_meta( $post->ID, $field, $_POST[ $field ] );
				endif;
			endforeach;
		endif;
	endif;
}

add_action( 'save_post', 'save_fup_quote_author', 1, 2 );


/**
 * Adapted from @link http://wp.tutsplus.com/tutorials/theme-development/how-to-display-metaboxes-according-to-the-current-post-format/
 */
function display_metaboxes() {

    if ( get_post_type() == "post" ) :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;


            var formats = { 'post-format-quote': 'fup-quote-citation' };
            var ids = "#fup-quote-citation";
                        function displayMetaboxes() {
                // Hide all post format metaboxes
                $(ids).hide();
                // Get current post format
                var selectedElt = $("input[name='post_format']:checked").attr("id");

                // If exists, fade in current post format metabox
                if ( formats[selectedElt] )
                    $("#" + formats[selectedElt]).fadeIn();
            }

            $(function() {
                // Show/hide metaboxes on page load
                displayMetaboxes();

                // Show/hide metaboxes on change event
                $("input[name='post_format']").change(function() {
                    displayMetaboxes();
                });
            });


        // ]]></script>
        <?php
    endif;
}

add_action( 'admin_print_scripts', 'display_metaboxes', 1000 );

