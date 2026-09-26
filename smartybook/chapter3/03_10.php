<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->assign('myDate', time());
$smarty->display('03_10.tpl');
