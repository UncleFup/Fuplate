<?php
/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function fup_caption( $output, $attr, $content ) {
	if ( is_feed() ):
		return $output;
	endif;

	$defaults = array(
							'id'        => '',
							'align'     => 'alignnone',
							'width'     => '',
							'caption'   => ''
							);

	$attr     = shortcode_atts( $defaults, $attr );

	// If the width is less than 1 or there is no caption, return the
	// content wrapped between the [caption] tags
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ):
		return $content;
	endif;

	// Set up the attributes for the caption <figure>
	$attributes = ( !empty( $attr['id'] )
		? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption '
	            . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	$output     = '<figure' . $attributes .'>';
	$output     .= do_shortcode( $content );
	$output     .= '<figcaption class="caption wp-caption-text">'
	            . $attr['caption'] . '</figcaption>';
	$output     .= '</figure>';

	return $output;
}
