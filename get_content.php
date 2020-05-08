<?php

$str = file_get_contents('');

$list = get_match('<ul>', '</ul>', $str);
//$links = get_match('href="', '"', $list, true);
$links = get_links($list, true);

print_r($links);

function get_match($bd, $kt, $str, $all = false)
{
	$bd = preg_quote($bd, '/');
	$kt = preg_quote($kt, '/');
	if ($all) {
		preg_match_all('@'.$bd.'\s*(.*?)\s*'.$kt.'@si', $str, $result);
	} else {
		preg_match('@'.$bd.'\s*(.*?)\s*'.$kt.'@si', $str, $result);
	}
	return $result[1];
}

function get_links($str, $all = false)
{
	if ($all) {
		preg_match_all('@href=(["\'])\s*(.*?)\s*\1@si', $str, $result);
	} else {
		preg_match('@href=(["\'])\s*(.*?)\s*\1@si', $str, $result);
	}
	return $result[2];
}