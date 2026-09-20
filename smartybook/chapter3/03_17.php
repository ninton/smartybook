<?php

use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
$person = [
    ['name' => '国枝', 'height' => '156'],
    ['name' => '大沢', 'height' => '165'],
    ['name' => '加藤', 'height' => '167'],
];
$smarty->assign('person', $person);
$smarty->display('03_17.tpl');
