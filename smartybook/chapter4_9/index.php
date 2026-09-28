<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->display('pages/chapter4_9/index.tpl');
