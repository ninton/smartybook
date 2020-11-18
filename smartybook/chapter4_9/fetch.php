<?php

require_once('../vendor/autoload.php');
require_once('./fetch_ini.php');
require_once('./fetch_funcs.php');
require_once(BAT_SRC_DIR . '/ini.php');
mb_internal_encoding('UTF-8');

// メニュー
$menu_arr = get_menu_arr($categories);

// 注目記事
$featured_arr = get_featured_arr(BAT_SRC_DIR . "/$csv");

$smarty = new Smarty();

$plugins_dir = $smarty->plugins_dir;
$plugins_dir[] = __DIR__;
$smarty->plugins_dir = $plugins_dir;

$smarty->assign('menu_arr', $menu_arr);
$smarty->assign('featured_arr', $featured_arr);

$buf = $smarty->fetch('menu.tpl');
file_put_contents('./html/menu.html', $buf);
print $buf;

$buf = $smarty->fetch('featured.tpl');
file_put_contents('./html/featured.html', $buf);
print $buf;
