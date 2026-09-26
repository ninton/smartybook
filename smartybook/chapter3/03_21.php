<?php

use Smarty\Smarty;

require_once '../../vendor/autoload.php';
$smarty = new Smarty();
$id = ['001', '002', '003'];
$location = ['北海道', '青森', '岩手'];
$address = ['001' => '北海道', '002' => '青森', '003' => '岩手'];
$smarty->assign('id', $id);
$smarty->assign('location', $location);
$smarty->assign('address', $address);
$smarty->display('03_21.tpl');
