<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

use SmartyBook\chapter5_3\src\emoji\Emoji;

use function SmartyBook\chapter5_3\src\emoji\emoji_output_handler;

final readonly class KetaiSetUp
{
    public static function contentType(string $carrierLongName): void
    {
        switch ($carrierLongName) {
            case 'docomo':
                header('Content-Type: application/xhtml+xml; charset=UTF-8');
                break;
        }
    }

    public static function outputHandler(string $carrierName): void
    {
        // 絵文字変換処理
        switch ($carrierName) {
            case 'docomo':
                break;

            case 'ezweb':
                Emoji::singleton('i_uni16', 'e_img_num')->output_setting('i_uni16', 'e_img_num');
                ob_start(emoji_output_handler(...));
                break;

            case 'vodafone':
            case 'softbank':
                Emoji::singleton('i_uni16', 's_uni16')->output_setting('i_uni16', 's_uni16');
                ob_start(emoji_output_handler(...));
                break;
        }
    }
}
