<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$result = mt_rand(1, 3);
$smarty->assign('result', $result);
$smarty->display('pages/chapter3/03_14.tpl');
