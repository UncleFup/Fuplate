<?php
/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from
 * Bootstrap
 *
 * @link http://twitter.github.com/bootstrap/components.html#thumbnails
 */
function fup_gallery( $attr ) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( !empty( $attr['ids'] ) ):
	    if ( empty( $attr['orderby'] ) ):
	        $attr['orderby'] = 'post__in';
    	endif;
	    $attr['include'] = $attr['ids'];
    endif;

    $output = apply_filters( 'post_gallery', '', $attr );

    if ( '' != $output ):
	    return $output;
    endif;

    if ( isset( $attr['orderby'] ) ):
	    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    	if ( !$attr['orderby'] ):
  	        unset( $attr['orderby'] );
    	endif;
    endif;

    extract( shortcode_atts( array(
									'order'      => 'ASC',
									'orderby'    => 'menu_order ID',
									'id'         => $post->ID,
									'itemtag'    => '',
									'icontag'    => '',
									'captiontag' => '',
									'columns'    => 3,
									'size'       => 'thumbnail',
									'include'    => '',
									'exclude'    => '',
									'link'       => 'file'
									), $attr ) );

    $id = intval( $id );

    if ( $order === 'RAND' ):
    	$orderby = 'none';
    endif;

    if ( !empty( $include ) ):
	    $_attachments = get_posts( array(
										'include'        => $include,
										'post_status'    => 'inherit',
										'post_type'      => 'attachment',
										'post_mime_type' => 'image',
										'order'          => $order,
										'orderby'        => $orderby
										) );

	    $attachments = array();
    	foreach ( $_attachments as $key => $val ):
	        $attachments[ $val->ID ] = $_attachments[ $key ];
    	endforeach;
	elseif ( !empty( $exclude ) ):
	    $attachments = get_children( array(
											'post_parent'    => $id,
											'exclude'        => $exclude,
											'post_status'    => 'inherit',
											'post_type'      => 'attachment',
											'post_mime_type' => 'image',
											'order'          => $order,
											'orderby'        => $orderby
											) );
    else:
    	$attachments = get_children( array(
											'post_parent'    => $id,
											'post_status'    => 'inherit',
											'post_type'      => 'attachment',
											'post_mime_type' => 'image',
											'order'          => $order,
											'orderby'        => $orderby
											) );
    endif;

    if ( empty( $attachments ) ):
	    return '';
    endif;

    if ( is_feed() ):
	    $output = "\n";
    	foreach ( $attachments as $att_id => $attachment ):
	        $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
    	endforeach;
    	return $output;
    endif;

    $output = '<ul class="thumbnails gallery">';

    $i = 0;
    foreach ( $attachments as $id => $attachment ):
	    $image = ( 'file' == $link )
			? wp_get_attachment_link( $id, $size, false, false )
			: wp_get_attachment_link( $id, $size, true, false );

    	$output .= '<li>' . $image;
    	if ( trim( $attachment->post_excerpt ) ):
    		$output .= '<div class="caption hidden">'
    				. wptexturize( $attachment->post_excerpt ) . '</div>';
    	endif;
    	$output .= '</li>';
    endforeach;

    $output .= '</ul>';

    return $output;
}
