<?php
/**
 * Clean up the_excerpt()
 */
function fup_excerpt_length( $length ) {
    return POST_EXCERPT_LENGTH;
}

function fup_excerpt_more( $more ) {
    return ' &hellip; <a href="' . get_permalink() . '">'
           . __('Continued', 'fup') . '</a>';
}
