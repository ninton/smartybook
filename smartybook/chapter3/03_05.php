<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
// 連想配列
$sites = ['name' => 'Google', 'url' => 'http://www.google.com/'];
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_05.tpl');
