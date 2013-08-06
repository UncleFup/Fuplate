<?php
/**
 * Clean up output of stylesheet <link> tags
 */
function fup_clean_style_tag($input) {
	$pattern = "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' "
	         . "type='text/css' media='(.*)' />!";
	preg_match_all($pattern, $input, $matches);

	// Only display media if it is meaningful
	$media = ( '' !== $matches[3][0] && 'all' !== $matches[3][0])
		? ' media="' . $matches[3][0] . '"' : '';

	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media
		   . '>' . "\n";
}
