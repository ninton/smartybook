<?php
require_once("ini.php");
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);
//adminページ用
$smarty->assign("categories", $categories);
//認証開始
$oAuth->start();
//認証が通った際の処理
if($oAuth->getAuth()){
	if ($_POST["title"]) {
		// 画像のアップロード
		if(!is_dir($imageDir)){
			mkdir($imageDir);
		}
		if(is_uploaded_file(@$_FILES["image"]["tmp_name"])){
			copy($_FILES["image"]["tmp_name"], $imageDir.$_FILES["image"]["name"]);
			$smarty->assign("imageFile", $imageDir.$_FILES["image"]["name"]);
		}
		$smarty->assign("category", $_POST["category"]);
		$smarty->assign("title", stripslashes($_POST["title"]));
		$smarty->assign("contents", stripslashes($_POST["contents"]));
		$smarty->assign("date", $_POST["date"]);
		//出力
		$smarty->display("confirm.tpl");
	} else {
		$smarty->display("admin.tpl");
	}
}
?>

