<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Chang title to slug</title>
	<script>
		function ChangeToSlug() {
			var title, slug;
			//Lấy text từ thẻ input title 
			title = document.getElementById("title").value;
			//Đổi chữ hoa thành chữ thường
			slug = title.toLowerCase();
			//Đổi ký tự có dấu thành không dấu
			slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
			slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
			slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
			slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
			slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
			slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
			slug = slug.replace(/đ/g, 'd');
			//Xóa các ký tự đặt biệt
			slug = slug.replace(/[^a-z0-9]/g, ' ');
			slug = slug.replace(/\s+/g, ' ');
			slug = slug.trim();
			//Đổi khoảng trắng thành ký tự gạch ngang
			slug = slug.replace(/ /g, "-");
			//In slug ra textbox có id “slug”
			document.getElementById('slug').value = slug;
		}
	</script>
</head>

<body>
	<form> Title :
		<input type="text" id="title" value="" size="50" onkeyup="ChangeToSlug();" />
		<br />
		<br /> Slug :
		<input type="text" id="slug" value="" size="50" /> </form>
</body>

</html>