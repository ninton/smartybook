<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('text', "'> Good Web = PHP & Smarty + Idea'");
$smarty->display('pages/chapter3/03_09.tpl');
