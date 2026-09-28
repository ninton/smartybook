<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$member = ['斉藤', '中村', '米谷' ,'鈴木' ,'伊野口' ,'渡部' , '松本'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('member', $member);
$smarty->display('pages/chapter3/03_20.tpl');
