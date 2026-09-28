<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$siteName = 'スノーボード関連本';
$bookList = ['ボードの選び方', 'ゲレンデマップ', 'ウエア・カタログ'];
$newBook = 'スノーボード・テクニック';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('bookList', $bookList);
$smarty->assign('newBook', $newBook);
$smarty->display('pages/chapter3/03_13.tpl');
