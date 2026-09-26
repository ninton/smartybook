<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$group = [
    ['森永', '国枝'],
    ['水村', '渋谷', '原田'],
    ['北野', '村井'],
];
$smarty->assign('group', $group);
$smarty->display('03_16.tpl');
