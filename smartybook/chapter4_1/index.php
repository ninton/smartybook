<?php

/**
 * @var string $siteName
 * @var string $home
 * @var array $categories
 */

require_once('ini.php');
use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
$smarty->display('index.tpl');
