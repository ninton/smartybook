<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$member = array("斉藤", "中村", "米谷" ,"鈴木" ,"伊野口" ,"渡部" , "松本");
$smarty->assign("member", $member);
$smarty->display("03_20.tpl");
