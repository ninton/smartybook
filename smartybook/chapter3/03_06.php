<?php

use App\Smarty\SmartyFactory;
use SmartyBook\chapter3\src\Bookmark;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// Bookmarkオブジェクトの作成
$bookmark = new Bookmark('Google', 'https://www.google.com/');

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('bookmark', $bookmark);
$smarty->display('pages/chapter3/03_06.tpl');
