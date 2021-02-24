<?php
//https://www.webslesson.info/2018/06/how-to-create-unique-url-slug-in-php.html
$slug = 'hahaha';
$data = ['hahaha', 'hehehe', 'hihi', 'hahaha-1'];

if(in_array($slug, $data))
{
	$count = 0;
	while( in_array( ($slug . '-' . ++$count ), $data) );
	$slug = $slug . '-' . $count;
}

echo $slug;