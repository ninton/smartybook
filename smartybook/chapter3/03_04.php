<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$sites = ['Google', 'MSN', ['Yahoo!', 'Yahoo!Japan']];
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_04.tpl');
