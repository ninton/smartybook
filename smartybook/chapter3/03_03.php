<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
$sites = ['Google', 'MSN', 'Yahoo!'];
$smarty->assign('sites', $sites);
$smarty->display('03_03.tpl');
