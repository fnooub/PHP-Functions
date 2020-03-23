<?php

//https://stackoverflow.com/questions/1813098/php-array-to-list
//code by acmol
function array2ul($array) {
    $out = "<ul>";
    foreach($array as $key => $elem){
        if(!is_array($elem)){
                $out .= "<li><span>$key:[$elem]</span></li>";
        }
        else $out .= "<li><span>$key</span>".array2ul($elem)."</li>";
    }
    $out .= "</ul>";
    return $out; 
}

/**
 * Converts a multi-level array to UL list.
 */
function array2ul($array) {
  $output = '<ul>';
  foreach ($array as $key => $value) {
    $function = is_array($value) ? __FUNCTION__ : 'htmlspecialchars';
    $output .= '<li><b>' . $key . ':</b> <i>' . $function($value) . '</i></li>';
  }
  return $output . '</ul>';
}
