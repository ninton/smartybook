<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$id = ['001', '002', '003'];
$location = ['北海道', '青森', '岩手'];
$address = ['001' => '北海道', '002' => '青森', '003' => '岩手'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('id', $id);
$smarty->assign('location', $location);
$smarty->assign('address', $address);
$smarty->display('pages/chapter3/03_21.tpl');
