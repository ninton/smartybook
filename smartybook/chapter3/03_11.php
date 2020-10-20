<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$body = <<<ABC
nl2br修飾子は、改行文字を&lt;br /&gt;タグに置換します。
改行文字はそのままではブラウザでは認識されません。
ABC;
$smarty->assign("body", $body);
$smarty->display("03_11.tpl");
?>