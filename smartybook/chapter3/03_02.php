<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$name = 'Smartyさん';
$type = 'テンプレート・エンジン';
$smarty->assign('name', $name);
$smarty->assign('type', $type);
$smarty->display('pages/chapter3/03_02.tpl');
