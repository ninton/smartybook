<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
$sites = ['Google', 'MSN', ['Yahoo!', 'Yahoo!Japan']];
$smarty->assign('sites', $sites);
$smarty->display('03_04.tpl');
