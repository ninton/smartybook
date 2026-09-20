<?php

require_once('ini.php');
use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('categories', $categories);
//出力
$smarty->display('admin.tpl');
