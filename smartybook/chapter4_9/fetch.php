<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/fetch_ini.php';
require_once __DIR__ . '/fetch_funcs.php';
require_once BAT_SRC_DIR . '/ini.php';
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
$smarty->assign('menu_arr', $menu_arr);
$smarty->assign('featured_arr', $featured_arr);

$buf = $smarty->fetch('menu.tpl');
file_put_contents('./html/menu.html', $buf);
print $buf;

$buf = $smarty->fetch('featured.tpl');
file_put_contents('./html/featured.html', $buf);
print $buf;
