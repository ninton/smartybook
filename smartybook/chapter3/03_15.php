<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$name = ['八代', '国枝', '大石'];
$height = ['167', '156', '182', '200'];
$smarty->assign('name', $name);
$smarty->assign('height', $height);
$smarty->display('pages/chapter3/03_15.tpl');
