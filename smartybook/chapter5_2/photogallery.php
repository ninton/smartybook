<?php

// 初期設定
$imgDir = "./images/";
$slideFlag = "on";
$slideTerm = "5000";

// Smartyの読み込み
require_once("../smarty/libs/Smarty.class.php");
// Smartyオブジェクトの作成
$smarty = new Smarty();
// デリミタタグの変更
$smarty->left_delimiter  = "{{";
$smarty->right_delimiter = "}}";

// 画像ファイルパスを取得（配列）
$images = glob("$imgDir*.{jpg,png,gif}", GLOB_BRACE);

// テンプレート変数の割り当て
$smarty->assign("images", $images);
$smarty->assign("slideFlag", $slideFlag);
$smarty->assign("slideTerm", $slideTerm);
// 出力
$smarty->display("photogallery.tpl");
