<?php

$db = new PDO("mysql:host=localhost;dbname=en_ebooks;charset=utf8", "root", "");

print_r(new_search('Nguyễn Nhật Ánh', 'author', 'one'));
//$sql = "SELECT * FROM ebooks WHERE title LIKE BINARY '%Mắt Biếc%'";
//print_r($db->query($sql)->fetch());

function new_search($str, $meta = 'title', $type = 'one')
{
	global $db;
	$sql = "SELECT * FROM ebooks WHERE $meta LIKE ";
	if ($type == 'one') {
		$sql .= "BINARY '".$str."'";
	} elseif ($type == 'two') {
		$sql .= "BINARY '%".$str."%'";
	} elseif ($type == 'three') {
		$sql .= "'".$str."'";
	} elseif ($type == 'four') {
		$sql .= "'%".$str."%'";
	}
	return $db->query($sql)->fetchAll();
}
