<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$siteName = 'スノーボード関連本';
$bookList = ['ボードの選び方', 'ゲレンデマップ', 'ウエア・カタログ'];
$newBook = 'スノーボード・テクニック';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::configure();
$smarty->assign('siteName', $siteName);
$smarty->assign('bookList', $bookList);
$smarty->assign('newBook', $newBook);
$smarty->display('pages/chapter3/03_13.tpl');
