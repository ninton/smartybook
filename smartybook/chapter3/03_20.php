<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$member = ['斉藤', '中村', '米谷' ,'鈴木' ,'伊野口' ,'渡部' , '松本'];
$smarty->assign('member', $member);
$smarty->display('pages/chapter3/03_20.tpl');
