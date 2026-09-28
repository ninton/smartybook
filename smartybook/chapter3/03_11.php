<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$body = <<<ABC
nl2br修飾子は、改行文字を&lt;br /&gt;タグに置換します。
改行文字はそのままではブラウザでは認識されません。
ABC;

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('body', $body);
$smarty->display('pages/chapter3/03_11.tpl');
