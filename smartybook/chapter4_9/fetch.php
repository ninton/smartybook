<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/fetch_funcs.php';
require_once __DIR__ . '/modifier.mb_truncate.php';

/**
 * @var list<string> $categories
 * @var string $csv
 */

// ----- メイン処理・データ操作 -----
// メニュー
$menu_arr = get_menu_arr($categories);

// 注目記事
$featured_arr = get_featured_arr($csv);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->registerPlugin('modifier', 'mb_truncate', smarty_modifier_mb_truncate(...));
// Smarty 5から、PHPの組み込み関数を暗黙的に修飾子として使えなくなりました。
// 明示的にプラグインとして登録する
$smarty->registerPlugin('modifier', 'basename', basename(...));
$smarty->assign('menu_arr', $menu_arr);
$smarty->assign('featured_arr', $featured_arr);

$buf = $smarty->fetch('pages/chapter4_9/menu.tpl');
file_put_contents('./html/menu.html', $buf);
print $buf;

$buf = $smarty->fetch('pages/chapter4_9/featured.tpl');
file_put_contents('./html/featured.html', $buf);
print $buf;
