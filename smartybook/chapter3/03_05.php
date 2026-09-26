<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
// 連想配列
$sites = ['name' => 'Google', 'url' => 'http://www.google.com/'];
$smarty->assign('sites', $sites);
$smarty->display('03_05.tpl');
