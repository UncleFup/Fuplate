<?php
/**
 * Add class="thumbnail" to attachment items
 */
function fup_attachment_link_class( $html ) {
	$postid = get_the_ID();
	$html   = str_replace( '<a', '<a class="thumbnail"', $html );
	return $html;
}
