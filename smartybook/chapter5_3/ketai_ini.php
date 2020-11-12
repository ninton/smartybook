<?php

require_once(dirname(__FILE__) . '/plib/semulator.php');

use \Net_UserAgent_Mobile;
use SmartyBook\chapter5_3\plib\emoji\Emoji;

$agent = Net_UserAgent_Mobile::factory();
$display = $agent->getDisplay();
// キャリア名称の調整
switch (strtolower($agent->getCarrierLongName())) {
    case 'docomo':
        header('Content-Type: application/xhtml+xml; charset=UTF-8');
        $_SERVER['carrier_ua'] = 'imode';
        break;

    case 'ezweb':
        $_SERVER['carrier_ua'] = 'ezweb';
        break;

    case 'vodafone':
    case 'softbank':
        $_SERVER['carrier_ua'] = 'softbank';
        break;

    default:
        $_SERVER['carrier_ua'] = 'imode';
        break;
}

// 絵文字変換処理
switch ($_SERVER['carrier_ua']) {
    case 'imode':
        break;

    case 'ezweb':
        Emoji::output_setting('i_uni16', 'e_img_num');
        ob_start('emoji_output_handler');
        break;

    case 'softbank':
        Emoji::output_setting('i_uni16', 's_uni16');
        ob_start('emoji_output_handler');
        break;
}
