<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// escape:html, escape:htmlall 用
$text = 'A & B <tag> "quote" \'single\' café © 日本語';
// escape:url 用
$keyword = 'PHP Smarty';
// escape:urlpathinfo 用
$fileName = 'sample report.pdf';

// その他の修飾子の用途は限定的
// escape:mail, escape:quotes, escape:javascript, escape:hex, escape:hexentity 用
$email = 'user@example.com';
$quoteText = "It's a \"test\"";
$jsText = "Line1\nLine2 'quote' </script>";
$hexText = 'AB';
$hexEntityText = 'A&B';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('text', $text);
$smarty->assign('keyword', $keyword);
$smarty->assign('fileName', $fileName);
$smarty->assign('email', $email);
$smarty->assign('quoteText', $quoteText);
$smarty->assign('jsText', $jsText);
$smarty->assign('hexText', $hexText);
$smarty->assign('hexEntityText', $hexEntityText);
$smarty->display('pages/chapter3/03_09.tpl');
