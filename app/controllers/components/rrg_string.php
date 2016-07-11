<?php
class RrgStringComponent extends Object {
	function strtocamel($str, $capitalizeFirst = true, $allowed = 'A-Za-z0-9') {
	    return preg_replace(
	        array(
	            '/([A-Z][a-z])/e', // all occurances of caps followed by lowers
	            '/([a-zA-Z])([a-zA-Z]*)/e', // all occurances of words w/ first char captured separately
	            '/[^'.$allowed.']+/e', // all non allowed chars (non alpha numerics, by default)
	            '/^([a-zA-Z])/e' // first alpha char
	        ),
	        array(
	            '" ".$1', // add spaces
	            'strtoupper("$1").strtolower("$2")', // capitalize first, lower the rest
	            '', // delete undesired chars
	            'strto'.($capitalizeFirst ? 'upper' : 'lower').'("$1")' // force first char to upper or lower
	        ),
	        $str
	    );
	}

    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $size = strlen( $chars );
        $str = '';
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }

}
?>