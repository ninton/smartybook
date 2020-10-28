<?php
// 設定ファイルの読み込み 
require_once('02_01_b.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登録確認 - <?php print $siteName;?></title>
</head>
<body>
<form method="post" action="02_06.php">
<table border="1">
<?php
$contents = nl2br($_POST['contents']);
// 入力データを確認
print '<tr>';
print '<td>カテゴリ</td>';
print '<td>'.$_POST['category'].'</td>';
print '</tr>';
print '<tr>';
print '<td>タイトル</td>';
print '<td>'.$_POST['title'].'</td>';
print '</tr>';
print '<tr>';
print '<td>本文</td>';
print '<td>'.$contents.'</td>';
print '</tr>';
print '<tr>';
print '<td>日時</td>';
print '<td>'.date("Y-m-d H:i:s", $_POST['date']).'</td>';
print '</tr>';
print '<tr>';
print '<td>画像</td>';

//画像ディレクトリがあるか調べ、無ければ作成する
if(!is_dir($imageDir)){
    mkdir($imageDir);
}

// ファイルをアップロードする
if(is_uploaded_file($_FILES['image']['tmp_name'])){
    copy($_FILES['image']['tmp_name'], $imageDir.$_FILES['image']['name']);
    $imageFile = $imageDir.$_FILES['image']['name'];
    print '<td><img src="'.$imageFile.'" /></td>';
}else {
    print '<td>ファイルは指定されていません。</td>';
}
print '</tr>';
?>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="登録">　<input type="button" value="戻る" onClick="history.back()"></td>
</tr>
</table>
<?php
print '<input type="hidden" name="category" value="'.$_POST['category'].'" />';
print '<input type="hidden" name="title" value="'.$_POST['title'].'" />';
print '<input type="hidden" name="contents" value="'.$_POST['contents'].'" />';
print '<input type="hidden" name="date" value="'.$_POST['date'].'" />';
print '<input type="hidden" name="image" value="'.$imageFile.'" />';
?>
</form>
</body>
</html>