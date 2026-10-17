<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// 初期設定
$imageDir = './images/';
$isAutoPlay = true;
$slideIntervalMilliseconds = '5000';

// ----- メイン処理・データ操作 -----
// 画像ファイルパスを取得（配列）
$images = glob("$imageDir*.{jpg,png,gif}", GLOB_BRACE);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
header('Content-Type: text/javascript; charset=utf-8');

// Smartyオブジェクトの作成
$smarty = new Smarty();
// デリミタタグの変更: Smarty 5 からメソッドで設定するようになった
$smarty->setLeftDelimiter('{{');
$smarty->setRightDelimiter('}}');
// テンプレート変数の割り当て
$smarty->assign('images', $images);
$smarty->assign('isAutoPlay', $isAutoPlay);
$smarty->assign('slideIntervalMilliseconds', $slideIntervalMilliseconds);
$smarty->display('pages/chapter5_2/photogallery.tpl');
