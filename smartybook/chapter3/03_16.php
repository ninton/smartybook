<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$group = array(
    array("森永", "国枝"),
    array("水村", "渋谷", "原田"),
    array("北野", "村井")
);
$smarty->assign("group", $group);
$smarty->display("03_16.tpl");
