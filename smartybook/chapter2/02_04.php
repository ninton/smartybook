<?php
// 設定ファイルの読み込み
require_once('02_01_b.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登録フォーム - <?php print $siteName;?></title>
</head>
<body>
<form method="post" action="02_05.php" enctype="multipart/form-data">
<table width="100%" border="1">
<tr>
<td>カテゴリ</td>
<td>
    <select name="category">
	<option value="Study">Study</option>
        <option value="Eating">Eating</option>
        <option value="Work">Work</option>
    </select>
</td>
</tr>
<tr>
    <td>タイトル</td>
    <td><input type="text" name="title" /></td>
</tr>
<tr>
    <td>本文</td>
    <td><textarea name="contents"></textarea></td>
</tr>
<tr>
    <td>日時</td>
    <td><?php print date("Y-m-d H:i:s", time()); ?><input type="hidden" name="date" value="<?php print time(); ?>" /></td>
</tr>
<tr>
    <td>画像</td>
    <td><input type="file" name="image" /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="登録確認" /></td>
</tr>
</table>
</form>
</body>
</html>
