<?php

function url_slug($str, $separator = '-', $lowercase = FALSE)
{
	$characters = array(
		'/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/' => 'a',
		'/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/' => 'e',
		'/ì|í|ị|ỉ|ĩ/' => 'i',
		'/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/' => 'o',
		'/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/' => 'u',
		'/ỳ|ý|ỵ|ỷ|ỹ/' => 'y',
		'/đ/' => 'd',
		'/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/' => 'A',
		'/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/' => 'E',
		'/Ì|Í|Ị|Ỉ|Ĩ/' => 'I',
		'/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/' => 'O',
		'/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/' => 'U',
		'/Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'Y',
		'/Đ/' => 'D'
	);

	$str = preg_replace(array_keys($characters), array_values($characters), $str);
	if ($separator === 'dash')
	{
		$separator = '-';
	}
	elseif ($separator === 'underscore')
	{
		$separator = '_';
	}		
	if ($lowercase === TRUE)
	{
		$str = strtolower($str);
	}
	$str = preg_replace('/[^A-Za-z0-9]/', ' ', $str); //ngoài a-z0-9 thì chuyển sang khoảng trắng
	$str = preg_replace('/\s\s+/', ' ', $str); //2 khoảng trắng trở lên thì chỉ lấy 1
	$str = trim($str); //loại bỏ khoảng trắng đầu cuối
	$str = str_replace(' ', $separator, $str);
	return $str;
}

echo url_slug('Ta đang tìm cách quên người!', 'underscore', TRUE);