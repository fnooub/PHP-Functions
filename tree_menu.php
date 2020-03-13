<?php

$categories = array(
	array("id" => 1, "title" => "PHP", "parent_id" => 0),
	array("id" => 2, "title" => "JAVA", "parent_id" => 0),
	array("id" => 3, "title" => "HTML", "parent_id" => 0),
	array("id" => 4, "title" => "PHP Codeigniter", "parent_id" => 1),
	array("id" => 5, "title" => "PHP Laravel", "parent_id" => 1),
	array("id" => 6, "title" => "Laravel plugin", "parent_id" => 5),
	array("id" => 7, "title" => "W3C", "parent_id" => 3)
);

?>
<table border="1" cellspacing="0" cellpadding="5">
	<tr>
		<td><strong>Chuyên mục</strong></td>
	</tr>
	<?php showCategories($categories); ?>
</table>
<?php

function showCategories($categories, $parent_id = 0, $char = '')
{
	foreach ($categories as $key => $item)
	{
		// Nếu là chuyên mục con thì hiển thị
		if ($item['parent_id'] == $parent_id)
		{
			echo '<tr>';
			echo '<td>';
			echo $char . $item['title'];
			echo '</td>';
			echo '</tr>';
			// Xóa chuyên mục đã lặp
			unset($categories[$key]);

			// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
			showCategories($categories, $item['id'], $char . '|---');
		}
	}
}

