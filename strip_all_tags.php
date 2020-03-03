<?php

function wp_strip_all_tags( $string, $remove_breaks = false ) {
	$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
	$string = strip_tags( $string );

	if ( $remove_breaks ) {
		$string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
	}

	return trim( $string );
}

$html = '<strong>I am not strong</strong>';
var_dump($html);
//output '<strong>I am not strong</strong>'
 
var_dump(wp_strip_all_tags($html));
//output 'I am not strong'