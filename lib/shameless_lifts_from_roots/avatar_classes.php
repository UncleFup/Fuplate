<?php
function fup_get_avatar( $avatar ) {
    $avatar = str_replace(
    						"class='avatar",
    						"class='avatar media-object",
    						$avatar
    						);
    return $avatar;
}
