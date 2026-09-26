<?php

use Smarty\Smarty;

require_once '../../vendor/autoload.php';
$smarty = new Smarty();
$name = ['八代', '国枝', '大石'];
$height = ['167', '156', '182', '200'];
$smarty->assign('name', $name);
$smarty->assign('height', $height);
$smarty->display('03_15.tpl');
