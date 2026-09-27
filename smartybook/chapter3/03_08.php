<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('name1', 'Smartyさん');
$smarty->assign('name2', '');
$smarty->display('pages/chapter3/03_08.tpl');
