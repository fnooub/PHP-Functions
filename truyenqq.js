// ==UserScript==
// @name         Truyenqq.com
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        http://truyenqq.com/truyen-tranh/*.html
// @require      https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js
// @grant        none
// ==/UserScript==

(function($, window, document) {
	'use strict';

	function to_slug(str)
	{
		// Chuyển hết sang chữ thường
		str = str.toLowerCase();     

		// xóa dấu
		str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
		str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
		str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
		str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
		str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
		str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
		str = str.replace(/(đ)/g, 'd');

		// Xóa ký tự đặc biệt
		str = str.replace(/[^a-z0-9]/g, ' ').trim();
		// loại bỏ 2 khoảng trắng trở lên
		return str.replace(/\s+/g, '-');
	}

	function randomArray(arr) {
		return arr[Math.floor(Math.random() * arr.length)];
	}

	function save() {
		var title = $('span[itemprop="name"]:eq(1)').text().trim();
		var chapTitle = $('span[itemprop="name"]:eq(2)').text().trim();
		data = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Sedgwick+Ave+Display&display=swap" rel="stylesheet"><style>::-webkit-scrollbar {width: 0;}body{background-image: url("https://i.imgur.com/Sd684Vr.jpg");background-color: #cccccc;margin:30px auto;text-align:center;max-width:1000px;background-attachment:fixed;}img{width:100%;display: block;}.demo-wrap{position:relative;border: 3px solid white; margin-bottom: 50px;}.demo-wrap:before{content:" ";display:block;position:absolute;left:0;top:0;width:100%;height:100%;opacity:.6;background-image:url(' + randomImg + ');background-repeat:no-repeat;background-position:50% 0;background-size:cover}.demo-content{position:relative;width:100%;height:700px}.center{margin:0;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);border:3px solid green;background-color:#fff;padding:30px 20px;text-align:center;width:700px}.title{font-family:"Sedgwick Ave Display",cursive;font-size:45px}.chapTitle{font-size:60px;color:red;text-transform:uppercase;-webkit-text-stroke:3px #ff5722}</style></head><body><div><div class="demo-wrap"><div class="demo-content"><div class="center"><div class="title">' + title + '</div><div class="chapTitle">' + chapTitle + '</div></div></div></div><div style="border: 3px solid white;">' + data + imgFooter + '</div></div></body></html>';

		var blob = new Blob([data], {
			encoding: 'UTF-8',
			type: 'text/html;charset=UTF-8'
		});
		$download.attr({
			href: window.URL.createObjectURL(blob),
			download: to_slug(chapTitle + '-' + title) + '.html'
		}).text('Tải xong').off('click');
	}

	var $download = $('<a></a>', {
			href: '#download',
			style: 'background-color:lightblue; padding: 5px',
			text: 'Tải xuống',
		}),
		data = '',
		randomImg = '',
		imgFooterRandom = [
			'http://res.cloudinary.com/fivegins/image/upload/v1617859732/luufiles/8433x2_fbihdh.jpg',
			'http://res.cloudinary.com/fivegins/image/upload/v1617859733/luufiles/37lxn1x_s9rgrn.jpg'
		],
		imgFooter = '<img src="' + randomArray(imgFooterRandom) + '">';

	$download.insertAfter('h1');
	$download.one('click contextmenu', function(e) {
		e.preventDefault();
		var $img = $('.story-see-content img.lazy');
		var img = [];
		$img.each(function(){
			img.push($(this).attr('src'));
		});
		for (var i = 0; i < img.length; i++) {
			data += '<img src="' + img[i] + '">\n';
		}
		randomImg = randomArray(img);
		console.log(randomImg);
		console.log(data);
		save();
	});

})(jQuery, window, document);