<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_4\src\SmartyPlugin;

final class NoticeTextFunction
{
    /**
     * @param array{siteName: string} $params
     * @return string
     */
    public static function render(array $params): string
    {
        return '下記バナーを自由にお使いください<br /><img src="./images/banner.gif" /><br />' . $params['siteName'];
    }
}
