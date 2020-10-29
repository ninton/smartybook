<?php

require_once("ini.php");
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);

// 画像のアップロード
if (!is_dir($imageDir)) {
    mkdir($imageDir);
}
if (is_uploaded_file(@$_FILES["image"]["tmp_name"])) {
    copy($_FILES["image"]["tmp_name"], $imageDir . $_FILES["image"]["name"]);
    $smarty->assign("imageFile", $imageDir . $_FILES["image"]["name"]);
}

$smarty->assign("category", $_POST["category"]);
$smarty->assign("title", stripslashes($_POST["title"]));
$smarty->assign("contents", stripslashes($_POST["contents"]));
$smarty->assign("date", $_POST["date"]);

$smarty->display("confirm.tpl");
