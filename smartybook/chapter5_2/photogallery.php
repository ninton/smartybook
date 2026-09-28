<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// 初期設定
$imgDir = './images/';
$slideFlag = 'on';
$slideTerm = '5000';

// ----- メイン処理・データ操作 -----
// 画像ファイルパスを取得（配列）
$images = glob("$imgDir*.{jpg,png,gif}", GLOB_BRACE);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
// Smartyオブジェクトの作成
$smarty = new Smarty();
// デリミタタグの変更: Smarty 5 からメソッドで設定するようになった
$smarty->setLeftDelimiter('{{');
$smarty->setRightDelimiter('}}');
// テンプレート変数の割り当て
$smarty->assign('images', $images);
$smarty->assign('slideFlag', $slideFlag);
$smarty->assign('slideTerm', $slideTerm);
$smarty->display('pages/chapter5_2/photogallery.tpl');
