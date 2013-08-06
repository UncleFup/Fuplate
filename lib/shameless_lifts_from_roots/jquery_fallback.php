<?php
// http://wordpress.stackexchange.com/a/12450
function fup_jquery_local_fallback( $src, $handle ) {
  static $add_jquery_fallback = false;

  if ( $add_jquery_fallback ) {
    echo '<script>window.jQuery || document.write(\'<script src="'
    	 . get_template_directory_uri()
    	 . '/js/vendor/jquery-1.10.2.min.js"><\/script>\')</script>'
         . "\n";
    $add_jquery_fallback = false;
  }

  if ( $handle === 'jquery' ) {
    $add_jquery_fallback = true;
  }

  return $src;
}
