<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$person = array("name" => "相田", "position" => "ゴールキーパー", "height" => "175cm");
$smarty->assign("person", $person);
$smarty->display("03_18.tpl");
