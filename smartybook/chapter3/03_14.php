<?php

use Smarty\Smarty;

require_once '../../vendor/autoload.php';
$smarty = new Smarty();
$result = mt_rand(1, 3);
$smarty->assign('result', $result);
$smarty->display('03_14.tpl');
