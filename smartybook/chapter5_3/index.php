<?php

require_once('./ini.php');
require_once('./ketai_ini.php');

/**
 * ini.phpで定義
 * @var $siteName
 * @var $home
 * @var $categories
 */
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("categories", $categories);
$smarty->display("index.tpl");
