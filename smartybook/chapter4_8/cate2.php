<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// ----- 入力値受取・前処理 -----
$php = basename($_SERVER['SCRIPT_NAME']);
$tpl = preg_replace('/\.php$/', '.tpl', $php);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
// Smarty5準備: preg_match修飾子を登録
$smarty->registerPlugin('modifier', 'preg_match', preg_match(...));
$smarty->display('pages/chapter4_8/' . $tpl);
