<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$body = <<<ABC
nl2br修飾子は、改行文字を&lt;br /&gt;タグに置換します。
改行文字はそのままではブラウザでは認識されません。
ABC;
$smarty->assign('body', $body);
$smarty->display('pages/chapter3/03_11.tpl');
