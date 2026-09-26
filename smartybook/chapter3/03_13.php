<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$siteName = 'スノーボード関連本';
$bookList = ['ボードの選び方', 'ゲレンデマップ', 'ウエア・カタログ'];
$newBook = 'スノーボード・テクニック';
$smarty->assign('siteName', $siteName);
$smarty->assign('bookList', $bookList);
$smarty->assign('newBook', $newBook);
$smarty->display('03_13.tpl');
