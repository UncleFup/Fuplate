<?php
/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function fup_embed_wrap( $cache, $url, $attr = '', $post_ID = '' ) {
    return '<div class="entry-content-asset">' . $cache . '</div>';
}
