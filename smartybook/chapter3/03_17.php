<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$person = array(
              array("name" => "国枝", "height" => "156"),
              array("name" => "大沢", "height" => "165"),
              array("name" => "加藤", "height" => "167")
        );
$smarty->assign("person", $person);
$smarty->display("03_17.tpl");
?>