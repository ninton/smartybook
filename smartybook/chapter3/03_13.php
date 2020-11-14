<?php

require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$siteName = "スノーボード関連本";
$bookList = array("ボードの選び方", "ゲレンデマップ", "ウエア・カタログ");
$newBook = "スノーボード・テクニック";
$smarty->assign("siteName", $siteName);
$smarty->assign("bookList", $bookList);
$smarty->assign("newBook", $newBook);
$smarty->display("03_13.tpl");
