<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$siteName = 'スノーボード関連本';
$bookList = ['ボードの選び方', 'ゲレンデマップ', 'ウエア・カタログ'];
$newBook = 'スノーボード・テクニック';
$smarty->assign('siteName', $siteName);
$smarty->assign('bookList', $bookList);
$smarty->assign('newBook', $newBook);
$smarty->display('pages/chapter3/03_13.tpl');
