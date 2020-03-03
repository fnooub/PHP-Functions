<?php

function single_curl($link)
{
	// Tạo mới một cURL
	$ch = curl_init();

	// Cấu hình cho cURL
	curl_setopt($ch, CURLOPT_URL, $link); // Chỉ định địa chỉ lấy dữ liệu
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36'); // Giả tên trình duyệt $_SERVER['HTTP_USER_AGENT']
	curl_setopt($ch, CURLOPT_HEADER, 0); // Không kèm header của HTTP Reponse trong nội
	curl_setopt($ch, CURLOPT_TIMEOUT, 600); // Định timeout khi curl
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Trả kết quả về ở hàm curl_exec
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Không xác nhận chứng chì ssl

	// Thực thi cURL
	$result = curl_exec($ch);

	// Ngắt cURL, giải phóng
	curl_close($ch);

	return $result;

}

function multi_curl($links){
	$mh = curl_multi_init();
	foreach($links as $k => $link) {
		$ch[$k] = curl_init();
		curl_setopt($ch[$k], CURLOPT_URL, $link);
		curl_setopt($ch[$k], CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36');
		curl_setopt($ch[$k], CURLOPT_HEADER, 0);
		curl_setopt($ch[$k], CURLOPT_TIMEOUT, 0);
		curl_setopt($ch[$k], CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch[$k], CURLOPT_SSL_VERIFYPEER, 0);
		curl_multi_add_handle($mh, $ch[$k]);
	}
	$running = null;
	do {
		curl_multi_exec($mh, $running);
	} while($running > 0);
	foreach($links as $k => $link) {
		$result[$k] = curl_multi_getcontent($ch[$k]);
		curl_multi_remove_handle($mh, $ch[$k]);
	}
	curl_multi_close($mh);
	return join('', $result);

}

// luu anh ho tro ssl
function save_image($fullpath, $img) {
	// open file descriptor
	$fp = fopen ($fullpath, 'w+') or die('Unable to write a file'); 
	// file to download
	$ch = curl_init($img);
	// enable SSL if needed
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	// output to file descriptor
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// set large timeout to allow curl to run for a longer time
	curl_setopt($ch, CURLOPT_TIMEOUT, 600);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	// Enable debug output
	curl_setopt($ch, CURLOPT_VERBOSE, true);   
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}

echo single_curl('url');
echo multi_curl(array('https://vi.wikipedia.org/wiki/Trang_Ch%C3%ADnh', 'https://vi.wikipedia.org/wiki/Trang_Ch%C3%ADnh'));
echo save_image('wiki.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Wikipedia_wordmark.svg/250px-Wikipedia_wordmark.svg.png');