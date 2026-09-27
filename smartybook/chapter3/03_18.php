<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$person = ['name' => '相田', 'position' => 'ゴールキーパー', 'height' => '175cm'];
$smarty->assign('person', $person);
$smarty->display('pages/chapter3/03_18.tpl');
