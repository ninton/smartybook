<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// ----- テンプレートの初期化と描画 -----
// 予約変数 {$smarty} の確認用サンプル。
// 入力値・セッション・PHP定数などは必要に応じてPHP側で扱い、
// テンプレート内に閉じる表示設定のみ .conf 側へ寄せる。
$smarty = SmartyFactory::create();
$smarty->display('pages/chapter3/03_07.tpl');
