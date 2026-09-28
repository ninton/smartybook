<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->display('pages/chapter3/03_07.tpl');
