<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('text', "'> Good Web = PHP & Smarty + Idea'");
$smarty->display('pages/chapter3/03_09.tpl');
