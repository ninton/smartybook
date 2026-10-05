<?php

use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter3\src\BookMark;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// BookMarkオブジェクトの作成
$bookmark = new BookMark('Google', 'http://www.google.com/', '2006/11/01');

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('bookmark', $bookmark);
$smarty->display('pages/chapter3/03_06.tpl');
