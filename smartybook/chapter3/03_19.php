<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$person = [
    ['name' => '国枝', 'height' => '156cm'],
    ['name' => '大沢', 'height' => '165cm'],
    ['name' => '加藤', 'height' => '167cm'],
];
$smarty->assign('person', $person);
$smarty->display('pages/chapter3/03_19.tpl');
