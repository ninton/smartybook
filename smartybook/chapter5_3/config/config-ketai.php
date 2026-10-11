<?php

use SmartyBook\chapter5_3\src\emoji\Emoji;

use function SmartyBook\chapter5_3\src\emoji\emoji_output_handler;

$agent = new App\PearStub\NetUserAgentMobileCommonStub();

$display = $agent->getDisplay();
// キャリア名称の調整
switch (strtolower($agent->getCarrierLongName())) {
    case 'docomo':
        header('Content-Type: application/xhtml+xml; charset=UTF-8');
        $carrierName = 'imode';
        break;

    case 'ezweb':
        $carrierName = 'ezweb';
        break;

    case 'vodafone':
    case 'softbank':
        $carrierName = 'softbank';
        break;

    default:
        $carrierName = 'imode';
        break;
}

// 絵文字変換処理
switch ($carrierName) {
    case 'imode':
        break;

    case 'ezweb':
        Emoji::singleton('i_uni16', 'e_img_num')->output_setting('i_uni16', 'e_img_num');
        ob_start(emoji_output_handler(...));
        break;

    case 'softbank':
        Emoji::singleton('i_uni16', 's_uni16')->output_setting('i_uni16', 's_uni16');
        ob_start(emoji_output_handler(...));
        break;
}

$layoutMap = [
    'imode' => 'base_imode.tpl',
    'ezweb' => 'base_ezweb.tpl',
    'softbank' => 'base_softbank.tpl',
];
