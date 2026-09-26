<?php

require_once __DIR__ . '/ini.php';
use Smarty\Smarty;

/**
 * @var string $siteName
 * @var string $home
 * @var string $admin
 * @var list<string> $categories
 */

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('categories', $categories);
//出力
$smarty->display('admin.tpl');
