<?php

use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
$person = [
    ['name' => '国枝', 'height' => '156cm'],
    ['name' => '大沢', 'height' => '165cm'],
    ['name' => '加藤', 'height' => '167cm'],
];
$smarty->assign('person', $person);
$smarty->display('03_19.tpl');
