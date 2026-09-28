<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$person = ['name' => '相田', 'position' => 'ゴールキーパー', 'height' => '175cm'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('person', $person);
$smarty->display('pages/chapter3/03_18.tpl');
