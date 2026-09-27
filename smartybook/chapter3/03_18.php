<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$person = ['name' => '相田', 'position' => 'ゴールキーパー', 'height' => '175cm'];
$smarty->assign('person', $person);
$smarty->display('03_18.tpl');
