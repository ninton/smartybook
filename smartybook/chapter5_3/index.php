<?php

use Smarty\Smarty;

require_once('./ini.php');
require_once('./ketai_ini.php');

/**
 * ini.phpで定義
 * @var string $siteName
 * @var string $home
 * @var array<int, array<string, string>> $categories
 */
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
$smarty->display('index.tpl');
