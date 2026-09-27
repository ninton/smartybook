<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('myDate', time());
$smarty->display('pages/chapter3/03_10.tpl');
