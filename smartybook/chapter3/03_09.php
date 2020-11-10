<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("text", "'> Good Web = PHP & Smarty + Idea'");
$smarty->display("03_09.tpl");
