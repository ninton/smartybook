<?php

require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$person = array(
    array("name" => "国枝", "height" => "156cm"),
    array("name" => "大沢", "height" => "165cm"),
    array("name" => "加藤", "height" => "167cm")
);
$smarty->assign("person", $person);
$smarty->display("03_19.tpl");
